import time
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor, GradientBoostingRegressor
from sklearn.metrics import mean_squared_error, r2_score
import joblib
import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np

# Load data
data = pd.read_excel("deepLearningMarks.xlsx")

# Data preprocessing
X = data[['CAT-1', 'CAT-2', 'PCAT-1', 'PCAT-2', 'Attendance', 'CGPA', 'Active_Backlogs', 'Physical_Health']]
y = data['SEE_GPA']

# Handle NaN values
data = data.dropna(subset=['SEE_GPA'])
X = data[['CAT-1', 'CAT-2', 'PCAT-1', 'PCAT-2', 'Attendance', 'CGPA', 'Active_Backlogs', 'Physical_Health']]
X = X.fillna(0)  # Fill NaN values with 0 or you can use other imputation methods
y = data['SEE_GPA']

# Convert categorical data
X = pd.get_dummies(X, columns=['Physical_Health'], drop_first=True)

# Split data
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train models
rf = RandomForestRegressor(n_estimators=100, random_state=42)
gb = GradientBoostingRegressor(n_estimators=100, random_state=42)

# Measure training time
start_time = time.time()
rf.fit(X_train, y_train)
rf_training_time = time.time() - start_time

start_time = time.time()
gb.fit(X_train, y_train)
gb_training_time = time.time() - start_time

# Measure prediction time
start_time = time.time()
y_pred_rf = rf.predict(X_test)
rf_prediction_time = time.time() - start_time

start_time = time.time()
y_pred_gb = gb.predict(X_test)
gb_prediction_time = time.time() - start_time

# Ensemble predictions
y_pred = (y_pred_rf + y_pred_gb) / 2

# Evaluate
mse = mean_squared_error(y_test, y_pred)
r2 = r2_score(y_test, y_pred)
print(f'Mean Squared Error: {mse}')
print(f'R^2 Score: {r2}')

# Save models
joblib.dump(rf, 'rf_model.pkl')
joblib.dump(gb, 'gb_model.pkl')

# Save the columns of X_train
X_train.to_csv('X_train_columns.csv', index=False)

# Plot MSE and R² score
metrics = {
    'Metric': ['MSE', 'R² Score'],
    'Value': [mse, r2]
}
metrics_df = pd.DataFrame(metrics)

fig, ax1 = plt.subplots()

color = 'tab:blue'
ax1.set_xlabel('Metrics')
ax1.set_ylabel('MSE', color=color)
ax1.bar(metrics_df['Metric'], metrics_df['Value'], color=color)
ax1.tick_params(axis='y', labelcolor=color)

ax2 = ax1.twinx()
color = 'tab:red'
ax2.set_ylabel('R² Score', color=color)
ax2.plot(metrics_df['Metric'], metrics_df['Value'], color=color)
ax2.tick_params(axis='y', labelcolor=color)

fig.tight_layout()
plt.title('MSE and R² Score')
plt.show()

# Plot time complexity
time_complexity = {
    'Model': ['Random Forest', 'Gradient Boosting'],
    'Training Time': [rf_training_time, gb_training_time],
    'Prediction Time': [rf_prediction_time, gb_prediction_time]
}
time_complexity_df = pd.DataFrame(time_complexity)

fig, ax1 = plt.subplots()

color = 'tab:blue'
ax1.set_xlabel('Models')
ax1.set_ylabel('Training Time (s)', color=color)
ax1.bar(time_complexity_df['Model'], time_complexity_df['Training Time'], color=color, alpha=0.6)
ax1.tick_params(axis='y', labelcolor=color)

ax2 = ax1.twinx()
color = 'tab:red'
ax2.set_ylabel('Prediction Time (s)', color=color)
ax2.plot(time_complexity_df['Model'], time_complexity_df['Prediction Time'], color=color, marker='o')
ax2.tick_params(axis='y', labelcolor=color)

fig.tight_layout()
plt.title('Training and Prediction Time Complexity')
plt.show()

# Plot feature importances
fig, (ax1, ax2) = plt.subplots(1, 2, figsize=(12, 6))

# Random Forest feature importances
feat_importances_rf = pd.Series(rf.feature_importances_, index=X.columns)
feat_importances_rf.nlargest(10).plot(kind='barh', ax=ax1)
ax1.set_title('Random Forest Feature Importance')

# Gradient Boosting feature importances
feat_importances_gb = pd.Series(gb.feature_importances_, index=X.columns)
feat_importances_gb.nlargest(10).plot(kind='barh', ax=ax2)
ax2.set_title('Gradient Boosting Feature Importance')

plt.tight_layout()
plt.show()

# Example for CAT-1 scores
plt.figure(figsize=(10, 6))
sns.histplot(data['CAT-1'], bins=20, kde=True)
plt.title('Distribution of CAT-1 Scores')
plt.xlabel('CAT-1 Scores')
plt.ylabel('Frequency')
plt.show()

plt.figure(figsize=(10, 6))
sns.boxplot(x='Physical_Health', y='Attendance', data=data)
plt.title('Attendance by Physical Health Category')
plt.xlabel('Physical Health')
plt.ylabel('Attendance')
plt.show()

plt.figure(figsize=(10, 8))
sns.heatmap(data[['CAT-1', 'CAT-2', 'PCAT-1', 'PCAT-2', 'Attendance', 'CGPA', 'Active_Backlogs', 'SEE_GPA']].corr(), annot=True, cmap='coolwarm', linewidths=0.5)
plt.title('Correlation Matrix')
plt.show()

plt.figure(figsize=(8, 6))
sns.countplot(x='Physical_Health', data=data)
plt.title('Count of Students by Physical Health Category')
plt.xlabel('Physical Health')
plt.ylabel('Count')
plt.show()

sns.pairplot(data[['CAT-1', 'CAT-2', 'PCAT-1', 'PCAT-2', 'Attendance', 'CGPA', 'Active_Backlogs', 'SEE_GPA']])
plt.show()
