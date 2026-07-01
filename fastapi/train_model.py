"""
train_model.py — Replikasi persis alur training dari notebook ipynb.

Melatih 3 model:
  1. KMeans (K=4)     — clustering zona agroklimat
  2. Random Forest    — klasifikasi tanaman
  3. MLP              — klasifikasi tanaman

Menyimpan bundle ke crop_model.joblib berisi:
  rf, mlp, kmeans, scaler, le (LabelEncoder), feature_names
"""

import numpy as np
import pandas as pd
import joblib
from sklearn.preprocessing import StandardScaler, LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.cluster import KMeans
from sklearn.ensemble import RandomForestClassifier
from sklearn.neural_network import MLPClassifier
from sklearn.metrics import accuracy_score, classification_report

# ------------------------------------------------------------------
# 1. Load Dataset
# ------------------------------------------------------------------
print("Memuat dataset Crop_recommendation.csv ...")
df = pd.read_csv("Crop_recommendation.csv")
print(f"  >> {df.shape[0]} baris, {df.shape[1]} kolom")

features = ['N', 'P', 'K', 'temperature', 'humidity', 'ph', 'rainfall']

# ------------------------------------------------------------------
# 2. Pemisahan Fitur dan Target (Cell 11)
# ------------------------------------------------------------------
X = df[features].values
y = df['label'].values

# ------------------------------------------------------------------
# 3. Encoding Label Target (Cell 12)
# ------------------------------------------------------------------
le = LabelEncoder()
y_encoded = le.fit_transform(y)
print(f"  >> {len(le.classes_)} kelas tanaman: {list(le.classes_)}")

# ------------------------------------------------------------------
# 4. Normalisasi Fitur — StandardScaler (Cell 13)
# ------------------------------------------------------------------
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# ------------------------------------------------------------------
# 5. Pembagian Data: Train 80% / Test 20% (Cell 14)
# ------------------------------------------------------------------
X_train, X_test, y_train, y_test = train_test_split(
    X_scaled, y_encoded,
    test_size=0.2,
    random_state=42,
    stratify=y_encoded
)
print(f"  >> Data latih: {X_train.shape[0]}, Data uji: {X_test.shape[0]}")

# ------------------------------------------------------------------
# 6. KMeans Clustering — Zona Agroklimat (Cell 19)
# ------------------------------------------------------------------
K_OPTIMAL = 4

print(f"\nTraining KMeans (K={K_OPTIMAL}) ...")
kmeans = KMeans(
    n_clusters=K_OPTIMAL,
    random_state=42,
    n_init=10,
    max_iter=300
)
kmeans.fit(X_scaled)
clusters = kmeans.predict(X_scaled)

print("  Distribusi sampel per zona:")
for c in range(K_OPTIMAL):
    count = (clusters == c).sum()
    print(f"    Zona {c+1}: {count} sampel ({count/len(clusters)*100:.1f}%)")

# Centroid dalam skala asli
centroid_original = pd.DataFrame(
    scaler.inverse_transform(kmeans.cluster_centers_),
    columns=features
)
centroid_original.index = [f'Zona {i+1}' for i in range(K_OPTIMAL)]
print("\n  Profil Centroid (skala asli):")
print(centroid_original.round(2).to_string())

# ------------------------------------------------------------------
# 7. Random Forest (Cell 25)
# ------------------------------------------------------------------
print("\nTraining Random Forest ...")
rf = RandomForestClassifier(
    n_estimators=100,
    max_depth=None,
    min_samples_split=2,
    min_samples_leaf=1,
    random_state=42
)
rf.fit(X_train, y_train)
y_pred_rf = rf.predict(X_test)
acc_rf = accuracy_score(y_test, y_pred_rf)
print(f"  >> Accuracy RF: {acc_rf:.4f} ({acc_rf*100:.2f}%)")

# ------------------------------------------------------------------
# 8. MLP (Cell 25)
# ------------------------------------------------------------------
print("\nTraining MLP (Multi-Layer Perceptron) ...")
mlp = MLPClassifier(
    hidden_layer_sizes=(100, 50),
    activation='relu',
    solver='adam',
    max_iter=500,
    random_state=42,
    early_stopping=True,
    validation_fraction=0.1
)
mlp.fit(X_train, y_train)
y_pred_mlp = mlp.predict(X_test)
acc_mlp = accuracy_score(y_test, y_pred_mlp)
print(f"  >> Accuracy MLP: {acc_mlp:.4f} ({acc_mlp*100:.2f}%)")

# ------------------------------------------------------------------
# 9. Classification Report
# ------------------------------------------------------------------
print("\n" + "="*60)
print("Classification Report — Random Forest")
print("="*60)
print(classification_report(y_test, y_pred_rf, target_names=le.classes_))

print("="*60)
print("Classification Report — MLP")
print("="*60)
print(classification_report(y_test, y_pred_mlp, target_names=le.classes_))

# ------------------------------------------------------------------
# 10. Simpan Bundle ke crop_model.joblib (menggabungkan semua)
# ------------------------------------------------------------------
bundle = {
    'rf': rf,
    'mlp': mlp,
    'kmeans': kmeans,
    'scaler': scaler,
    'le': le,
    'feature_names': features,
    'n_clusters': K_OPTIMAL,
    'accuracy_rf': acc_rf,
    'accuracy_mlp': acc_mlp,
}

joblib.dump(bundle, "crop_model.joblib")
print("\nBundle berhasil disimpan ke crop_model.joblib")
print("  Isi bundle: rf, mlp, kmeans, scaler, le, feature_names")

# ------------------------------------------------------------------
# 11. Verifikasi — Demo Prediksi (mirip Cell 36)
# ------------------------------------------------------------------
print("\n" + "="*60)
print("VERIFIKASI — Demo Prediksi")
print("="*60)

test_cases = [
    {'N': 90, 'P': 42, 'K': 43, 'temperature': 25, 'humidity': 82, 'ph': 6.5, 'rainfall': 200,
     'desc': 'Lahan basah, nutrisi tinggi'},
    {'N': 20, 'P': 60, 'K': 20, 'temperature': 30, 'humidity': 50, 'ph': 7.0, 'rainfall': 60,
     'desc': 'Lahan kering, P tinggi'},
]

loaded = joblib.load("crop_model.joblib")
for tc in test_cases:
    inp = np.array([[tc['N'], tc['P'], tc['K'], tc['temperature'],
                     tc['humidity'], tc['ph'], tc['rainfall']]])
    inp_scaled = loaded['scaler'].transform(inp)

    pred_rf = loaded['le'].inverse_transform(loaded['rf'].predict(inp_scaled))[0]
    pred_mlp = loaded['le'].inverse_transform(loaded['mlp'].predict(inp_scaled))[0]
    zona = loaded['kmeans'].predict(inp_scaled)[0] + 1

    proba = loaded['rf'].predict_proba(inp_scaled)[0]
    top3_idx = proba.argsort()[-3:][::-1]
    top3 = [(loaded['le'].inverse_transform([idx])[0], proba[idx]*100) for idx in top3_idx]

    print(f"\n  {tc['desc']}:")
    print(f"    RF  -> {pred_rf}")
    print(f"    MLP -> {pred_mlp}")
    print(f"    Zona Agroklimat: {zona}")
    print(f"    Top 3: {', '.join([f'{c} ({p:.1f}%)' for c,p in top3])}")
