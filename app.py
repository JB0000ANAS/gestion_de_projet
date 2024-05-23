from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import train_test_split
import logging

app = Flask(__name__)

# Enable logging
logging.basicConfig(level=logging.DEBUG)

# Load data and train the model
df = pd.read_csv('co2_emissions_car__1_.csv')
df_duplicated = df[df.duplicated() == True]
indexs = df_duplicated.index
for i in indexs:
    df.drop(i, axis=0, inplace=True)

X = df[['Engine Size(L)', 'Cylinders', 'Fuel Consumption Comb (L/100 km)']]
y = df['CO2 Emissions(g/km)']
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
model = RandomForestRegressor(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    app.logger.debug(f"Received data for prediction: {data}")
    engine_size = data['engineSize']
    cylinders = data['cylinders']
    fuel_consumption = data['fuelConsumption']

    prediction = model.predict([[engine_size, cylinders, fuel_consumption]])[0]
    app.logger.debug(f"Prediction result: {prediction}")
    return jsonify({'predictedEmissions': prediction})

if __name__ == '__main__':
    app.run(debug=True)
