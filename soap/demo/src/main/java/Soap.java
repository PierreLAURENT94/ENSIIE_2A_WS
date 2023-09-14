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
    }

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
}
