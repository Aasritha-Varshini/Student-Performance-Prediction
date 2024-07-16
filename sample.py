import pandas as pd
from sklearn.model_selection import train_test_split
from lazypredict.Supervised import LazyRegressor
from sklearn.preprocessing import LabelEncoder

# Step 1: Load the dataset
data = pd.read_excel("deepLearningMarls.xlsx")  # Replace "your_dataset.csv" with the path to your dataset
# Step 2: Preprocess the data
# Drop irrelevant columns
data = data.drop(columns=['Roll Number', 'Name', 'Subject'])

# Encode categorical variables if necessary
label_encoders = {}
for column in ['Physical_Health']:
    label_encoders[column] = LabelEncoder()
    data[column] = label_encoders[column].fit_transform(data[column])

# Split the data into features (X) and target variable (y)
X = data.drop(columns=['SEE_GPA'])
y = data['SEE_GPA']

# Step 3: Split the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Step 4: Use LazyRegressor to automatically train and evaluate multiple regression algorithms
reg = LazyRegressor(verbose=0, ignore_warnings=True, predictions=True)
models, predictions = reg.fit(X_train, X_test, y_train, y_test)

print(models)
