package pl.esp8266.server.esp8266.adapter;

import com.google.gson.Gson;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Component;

import java.io.IOException;

@Component("HttpPostMethod")
public class HttpPostMethod {
    private Logger LOG = LoggerFactory.getLogger(EspAdapter.class);
    CloseableHttpClient client = HttpClients.createDefault();

    public void sendPost(String ip, String port, String path, Object data){
        try {
            String json = new Gson().toJson(data);
            String uri = ip + ":" + port + "/" + path;
            HttpPost httpPost = new HttpPost(uri);
            StringEntity entity = new StringEntity(json);
            httpPost.setEntity(entity);
            httpPost.setHeader("Accept", "application/json");
            httpPost.setHeader("Content-type", "application/json");

            CloseableHttpResponse response = client.execute(httpPost);
            LOG.info("Received status: {}",response.getStatusLine().getStatusCode());
           // client.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
