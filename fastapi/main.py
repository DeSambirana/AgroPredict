from fastapi import FastAPI
from pydantic import BaseModel
import numpy as np
import joblib

# ------------------------------------------------------------------
# Memuat bundle model (rf, mlp, kmeans, scaler, le)
# ------------------------------------------------------------------
bundle = joblib.load("crop_model.joblib")

rf = bundle['rf']
mlp = bundle['mlp']
kmeans = bundle['kmeans']
scaler = bundle['scaler']
le = bundle['le']
feature_names = bundle['feature_names']
n_clusters = bundle['n_clusters']

app = FastAPI(
    title="Crop Recommendation API",
    description="API prediksi rekomendasi tanaman menggunakan Random Forest, MLP, dan KMeans (zona agroklimat).",
    version="2.0.0",
)


class CropInput(BaseModel):
    N: float
    P: float
    K: float
    temperature: float
    humidity: float
    ph: float
    rainfall: float


@app.get("/")
def root():
    return {
        "message": "Crop Recommendation API sedang berjalan",
        "models": ["Random Forest", "MLP", "KMeans"],
        "features": feature_names,
        "classes": list(le.classes_),
        "n_clusters": n_clusters,
        "accuracy_rf": bundle.get('accuracy_rf'),
        "accuracy_mlp": bundle.get('accuracy_mlp'),
    }


@app.post("/predict")
def predict(data: CropInput):
    # Mengonversi input menjadi numpy array 2D
    input_array = np.array(
        [[data.N, data.P, data.K, data.temperature, data.humidity, data.ph, data.rainfall]]
    )

    # Normalisasi dengan scaler yang sama dari training
    input_scaled = scaler.transform(input_array)

    # --- Prediksi Random Forest ---
    pred_rf_encoded = rf.predict(input_scaled)[0]
    pred_rf_label = le.inverse_transform([pred_rf_encoded])[0]
    proba_rf = rf.predict_proba(input_scaled)[0]
    confidence_rf = float(np.max(proba_rf))

    # Top 3 crops dari RF
    top3_idx = proba_rf.argsort()[-3:][::-1]
    top3_crops = [
        {
            "crop": le.inverse_transform([idx])[0],
            "probability": round(float(proba_rf[idx]) * 100, 2)
        }
        for idx in top3_idx
    ]

    # --- Prediksi MLP ---
    pred_mlp_encoded = mlp.predict(input_scaled)[0]
    pred_mlp_label = le.inverse_transform([pred_mlp_encoded])[0]
    proba_mlp = mlp.predict_proba(input_scaled)[0]
    confidence_mlp = float(np.max(proba_mlp))

    # --- Prediksi Zona Agroklimat (KMeans) ---
    zona = int(kmeans.predict(input_scaled)[0]) + 1  # 1-indexed

    return {
        "prediction_rf": pred_rf_label,
        "prediction_mlp": pred_mlp_label,
        "confidence_rf": round(confidence_rf, 4),
        "confidence_mlp": round(confidence_mlp, 4),
        "zona_agroklimat": zona,
        "top3_crops": top3_crops,
        # backward compat — controller reads 'prediction'
        "prediction": pred_rf_label,
    }


if __name__ == "__main__":
    import uvicorn

    uvicorn.run("main:app", host="0.0.0.0", port=8000, reload=True)
