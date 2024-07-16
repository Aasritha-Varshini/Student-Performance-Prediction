import sys
import json
import pandas as pd
import joblib

# Load models
rf = joblib.load('rf_model.pkl')
gb = joblib.load('gb_model.pkl')

# Load columns
X_train_columns = pd.read_csv('X_train_columns.csv')

# Function to predict GPA based on input data
def predict_custom_data(input_data):
    # Convert JSON string to dictionary
    data = json.loads(input_data)

    # Prepare data for prediction
    custom_df = pd.DataFrame([data])
    custom_df = pd.get_dummies(custom_df, columns=['Physical_Health'], drop_first=True)

    # Ensure all columns used in training are present
    for col in X_train_columns.columns:
        if col not in custom_df.columns:
            custom_df[col] = 0

    # Align the order of columns with the training set
    custom_df = custom_df[X_train_columns.columns]

    # Predict using custom data
    pred_rf = rf.predict(custom_df)
    pred_gb = gb.predict(custom_df)
    ensemble_pred = (pred_rf + pred_gb) / 2

    return round(ensemble_pred[0],2)

# Read data from standard input (stdin)
input_data = sys.stdin.read()

# Predict GPA based on input data
prediction = predict_custom_data(input_data)

# Print the prediction
print(prediction)
