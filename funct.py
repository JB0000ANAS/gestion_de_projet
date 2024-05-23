import pandas as pd
import numpy as np
import plotly.express as px
import plotly.graph_objects as go
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_squared_error, r2_score

# Load data
df = pd.read_csv('co2_emissions_car__1_.csv')

# Data cleaning
df.drop_duplicates(inplace=True)

# Check the column names
print("Column names in the DataFrame:", df.columns)

# Select numeric columns
numeric_df = df.select_dtypes(include=[np.number])
print("Numeric column names in the DataFrame:", numeric_df.columns)

# Ensure the required columns are present in numeric_df
required_columns = ['Engine Size(L)', 'Cylinders', 'Fuel Consumption Comb (L/100 km)', 'CO2 Emissions(g/km)']
missing_columns = [col for col in required_columns if col not in numeric_df.columns]
if missing_columns:
    print(f"Missing columns: {missing_columns}")
else:
    # Plotly scatter matrix
    fig_scatter = px.scatter_matrix(numeric_df,
                                    dimensions=required_columns,
                                    color='CO2 Emissions(g/km)')
    fig_scatter.update_layout(autosize=True)

    # Save scatter matrix as JSON
    scatter_matrix_json = fig_scatter.to_json()
    with open("scatter_matrix.json", "w") as f:
        f.write(scatter_matrix_json)

    # Plotly heatmap
    correlation_matrix = numeric_df.corr()
    fig_heatmap = go.Figure(data=go.Heatmap(
                       z=correlation_matrix,
                       x=correlation_matrix.columns,
                       y=correlation_matrix.columns,
                       hoverongaps=False))
    fig_heatmap.update_layout(autosize=True)

    # Save heatmap as JSON
    heatmap_json = fig_heatmap.to_json()
    with open("heatmap.json", "w") as f:
        f.write(heatmap_json)

    # RandomForest Model
    X = df[['Engine Size(L)', 'Cylinders', 'Fuel Consumption Comb (L/100 km)']]
    y = df['CO2 Emissions(g/km)']
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
    model = RandomForestRegressor(n_estimators=100, random_state=42)
    model.fit(X_train, y_train)
    y_pred = model.predict(X_test)
    mse = mean_squared_error(y_test, y_pred)
    r2 = r2_score(y_test, y_pred)
    print(f'Mean Squared Error: {mse}')
    print(f'R² Score: {r2}')

# Function to calculate score
def calculate_score(emissions):
    if emissions <= 100:
        return 100
    elif emissions <= 150:
        return 90
    elif emissions <= 200:
        return 80
    elif emissions <= 250:
        return 70
    elif emissions <= 300:
        return 60
    else:
        return 50

# Function to perform prediction
def predict_emissions(engine_size, cylinders, fuel_consumption):
    predicted_emissions = model.predict([[engine_size, cylinders, fuel_consumption]])[0]
    score = calculate_score(predicted_emissions)
    return predicted_emissions, score

# Save prediction function as JavaScript
with open("prediction_function.js", "w") as f:
    f.write("""
function predictEmissions(engineSize, cylinders, fuelConsumption) {
    const predictedEmissions = %s;
    const score = %s;
    return [predictedEmissions, score];
}
""" % (model.predict([[2.0, 4, 7.0]])[0], calculate_score(model.predict([[2.0, 4, 7.0]])[0])))

# Create dropdowns for Car Make and Model
make_dropdown_options = list(df['Make'].unique())
model_dropdown_options = df[['Make', 'Model', 'CO2 Emissions(g/km)']].to_dict('records')

# Save dropdown options as JavaScript
with open("dropdown_options.js", "w") as f:
    f.write("""
const makeDropdownOptions = %s;
const modelDropdownOptions = %s;
""" % (make_dropdown_options, model_dropdown_options))

# Function to get the score for selected car
def get_score(make, model):
    selected_car = df[(df['Make'] == make) & (df['Model'] == model)]
    if not selected_car.empty:
        emissions = selected_car['CO2 Emissions(g/km)'].values[0]
        score = calculate_score(emissions)
    else:
        score = "Car model not found."
    return score

# Save get_score function as JavaScript
with open("get_score_function.js", "w") as f:
    f.write("""
function getScore(make, model) {
    const selectedCar = %s;
    if (!selectedCar.empty) {
        const emissions = selectedCar['CO2 Emissions(g/km)'].values[0];
        const score = %s;
        return score;
    } else {
        return "Car model not found.";
    }
}
""" % (df[(df['Make'] == "Toyota") & (df['Model'] == "Corolla")].to_dict('records'), calculate_score(df[(df['Make'] == "Toyota") & (df['Model'] == "Corolla")]['CO2 Emissions(g/km)'].values[0]) if not df[(df['Make'] == "Toyota") & (df['Model'] == "Corolla")].empty else "Car model not found."))