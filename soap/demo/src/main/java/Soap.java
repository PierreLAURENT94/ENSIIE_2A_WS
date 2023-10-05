import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import okhttp3.HttpUrl;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;

import java.io.IOException;

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
}
