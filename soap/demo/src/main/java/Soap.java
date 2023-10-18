import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import okhttp3.HttpUrl;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

public class Soap {

    public static void main(String[] args) {
        // tests
        try {
            JsonArray stations = fetchStations(1, "", "");
            for (JsonElement stationElement : stations) {
                JsonObject stationObject = stationElement.getAsJsonObject();
                int id = stationObject.get("id").getAsInt();
                String name = stationObject.get("name").getAsString();
                String city = stationObject.get("city").getAsString();
                System.out.println("ID: " + id + ", Name: " + name + ", City: " + city);
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    
        try {
            JsonObject station = fetchStationById(2);
            System.out.println("ID: " + station.get("id"));
            System.out.println("Name: " + station.get("name"));
            System.out.println("City: " + station.get("city"));
        } catch (IOException e) {
            e.printStackTrace();
        }

        Map<String, String> params = new HashMap<>();
        params.put("page", "1");
        // Add other parameters with the same way, example : params.put("name_of_the_parameter", "value");
        try {
            JsonArray trains = fetchTrains(params);
            for (JsonElement trainElement : trains) {
                JsonObject trainObject = trainElement.getAsJsonObject();
                
                int id = trainObject.get("id").getAsInt();
                
                JsonObject departureStation = trainObject.get("departureStation").getAsJsonObject();
                String departureName = departureStation.get("name").getAsString();
                String departureCity = departureStation.get("city").getAsString();
                
                String departureDateTime = trainObject.get("departureDateTime").getAsString();
                
                JsonObject arrivalStation = trainObject.get("arrivalStation").getAsJsonObject();
                String arrivalName = arrivalStation.get("name").getAsString();
                String arrivalCity = arrivalStation.get("city").getAsString();
                
                String arrivalDateTime = trainObject.get("arrivalDateTime").getAsString();
                
                int seatsAvailableBusiness = trainObject.get("seatsAvailableBusiness").getAsInt();
                double priceBusiness = trainObject.get("priceBusiness").getAsDouble();
                
                int seatsAvailableFirst = trainObject.get("seatsAvailableFirst").getAsInt();
                double priceFirst = trainObject.get("priceFirst").getAsDouble();
                
                int seatsAvailableStandard = trainObject.get("seatsAvailableStandard").getAsInt();
                double priceStandard = trainObject.get("priceStandard").getAsDouble();
                
                System.out.println("Train ID: " + id);
                System.out.println("Departure: " + departureName + ", " + departureCity + " at " + departureDateTime);
                System.out.println("Arrival: " + arrivalName + ", " + arrivalCity + " at " + arrivalDateTime);
                System.out.println("Business seats available: " + seatsAvailableBusiness + " at " + priceBusiness);
                System.out.println("First class seats available: " + seatsAvailableFirst + " at " + priceFirst);
                System.out.println("Standard seats available: " + seatsAvailableStandard + " at " + priceStandard);
                System.out.println("-----------------------------------------------------------");
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    // To get all stations from a name or a city
    public static JsonArray fetchStations(int page, String name, String city) throws IOException {
        OkHttpClient client = new OkHttpClient();

        HttpUrl.Builder urlBuilder = HttpUrl.parse("http://127.0.0.1:8000/stations").newBuilder();
        urlBuilder.addQueryParameter("page", Integer.toString(page));
        urlBuilder.addQueryParameter("name", name);
        urlBuilder.addQueryParameter("city", city);

        String url = urlBuilder.build().toString();

        Request request = new Request.Builder()
                .url(url)
                .build();

        try (Response response = client.newCall(request).execute()) {
            String jsonData = response.body().string();
            JsonObject jsonObject = JsonParser.parseString(jsonData).getAsJsonObject();
            return jsonObject.getAsJsonArray("hydra:member");
        }
    }

    // To get all informations about a station from a id
    public static JsonObject fetchStationById(int id) throws IOException {
        OkHttpClient client = new OkHttpClient();

        String url = "http://127.0.0.1:8000/stations/" + id;

        Request request = new Request.Builder()
                .url(url)
                .build();

        try (Response response = client.newCall(request).execute()) {
            String jsonData = response.body().string();
            JsonObject jsonObject = JsonParser.parseString(jsonData).getAsJsonObject();

            int stationId = jsonObject.get("id").getAsInt();
            String name = jsonObject.get("name").getAsString();
            String city = jsonObject.get("city").getAsString();

            JsonObject result = new JsonObject();
            result.addProperty("id", stationId);
            result.addProperty("name", name);
            result.addProperty("city", city);

            return result;
        }



    }
    // to get all informations about all trains (it depends on the filter)
    public static JsonArray fetchTrains(Map<String, String> parameters) throws IOException {
    OkHttpClient client = new OkHttpClient();

    HttpUrl.Builder urlBuilder = HttpUrl.parse("http://127.0.0.1:8000/trains").newBuilder();
    for (Map.Entry<String, String> entry : parameters.entrySet()) {
        urlBuilder.addQueryParameter(entry.getKey(), entry.getValue());
    }

    String url = urlBuilder.build().toString();

    Request request = new Request.Builder()
            .url(url)
            .build();

    try (Response response = client.newCall(request).execute()) {
        String jsonData = response.body().string();
        JsonObject jsonObject = JsonParser.parseString(jsonData).getAsJsonObject();
        return jsonObject.getAsJsonArray("hydra:member");
    }
}
}
