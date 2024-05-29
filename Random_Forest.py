import pandas as pd
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import train_test_split
import json


data = pd.read_csv('co2_emissions_car__1_.csv')  


X = data[['Engine Size(L)', 'Cylinders', 'Fuel Consumption Comb (L/100 km)']]
y = data['CO2 Emissions(g/km)']


X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)


rf_model = RandomForestRegressor(n_estimators=50, max_depth=10, random_state=42)
rf_model.fit(X_train, y_train)

# Evaluate the model
score = rf_model.score(X_test, y_test)
print(f'Model score: {score}')

model_params = {
    'n_estimators': rf_model.n_estimators,
    'max_depth': rf_model.max_depth,
    'min_samples_split': rf_model.min_samples_split,
    'min_samples_leaf': rf_model.min_samples_leaf,
    'max_features': rf_model.max_features,
    'estimators': []
}

for estimator in rf_model.estimators_:
    tree_params = {
        'feature_indices': estimator.tree_.feature.tolist(),
        'threshold': estimator.tree_.threshold.tolist(),
        'children_left': estimator.tree_.children_left.tolist(),
        'children_right': estimator.tree_.children_right.tolist(),
        'value': estimator.tree_.value.tolist()
    }
    model_params['estimators'].append(tree_params)


with open('random_forest_model_simplified.json', 'w') as file:
    json.dump(model_params, file)

print(' sucess ')
