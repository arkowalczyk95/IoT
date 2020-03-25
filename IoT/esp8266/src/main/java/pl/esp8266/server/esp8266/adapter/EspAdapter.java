package pl.esp8266.server.esp8266.adapter;

import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.entity.StringEntity;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.PropertySource;
import org.springframework.context.support.PropertySourcesPlaceholderConfigurer;
import org.springframework.stereotype.Component;
import pl.esp8266.server.esp8266.model.HumidityAction;
import pl.esp8266.server.esp8266.model.LightAction;
import pl.esp8266.server.esp8266.model.TemperatureAction;
import java.io.IOException;


@Component("EspAdapter")
public class EspAdapter {
    private Logger LOG = LoggerFactory.getLogger(EspAdapter.class);

    @Bean
    public static PropertySourcesPlaceholderConfigurer swaggerProperties() {
        PropertySourcesPlaceholderConfigurer p = new PropertySourcesPlaceholderConfigurer();
        p.setIgnoreUnresolvablePlaceholders(true);
        return p;
    }

    @Value("${temperature.temperatureAddress}")
    String temperatureAddress;
    @Value("${temperature.temperaturePort}")
    String temperaturePort;
    @Value("${temperature.temperatureUrl}")
    String temperatureUrl;
    @Value("${humidity.humidityAddress}")
    String humidityAddress;
    @Value("${humidity.humidityPort}")
    String humidityPort;
    @Value("${humidity.humidityUrl}")
    String humidityUrl;
    @Value("${light.lightAddress}")
    String lightAddress;
    @Value("${light.lightPort}")
    String lightPort;
    @Value("${light.lightUrl}")
    String lightUrl;

    @Value("${mock.value}")
    String value;

    @Value("${temperature.mock.temperatureAddressMock}")
    String temperatureAddressMock;
    @Value("${temperature.mock.temperaturePortMock}")
    String temperaturePortMock;
    @Value("${temperature.mock.temperatureUrlMock}")
    String temperatureUrlMock;
    @Value("${humidity.mock.humidityAddressMock}")
    String humidityAddressMock;
    @Value("${humidity.mock.humidityPortMock}")
    String humidityPortMock;
    @Value("${humidity.mock.humidityUrlMock}")
    String humidityUrlMock;
    @Value("${light.mock.lightAddressMock}")
    String lightAddressMock;
    @Value("${light.mock.lightPortMock}")
    String lightPortMock;
    @Value("${light.mock.lightUrlMock}")
    String lightUrlMock;


    @Autowired
    @Qualifier("HttpPostMethod")
    HttpPostMethod httpPostMethod;
    @Autowired
    @Qualifier("TemperatureAction")
    TemperatureAction temperatureAction;
    @Autowired
    @Qualifier("LightAction")
    LightAction lightAction;
    @Autowired
    @Qualifier("HumidityAction")
    HumidityAction humidityAction;

    public void sendTemperatureInstructions(TemperatureAction temperatureActionObject){
        if(value.equals("true")){
            httpPostMethod.sendPost(temperatureAddressMock, temperaturePortMock, temperatureUrlMock, temperatureActionObject);
        }else{
            httpPostMethod.sendPost(temperatureAddress, temperaturePort, temperatureUrl, temperatureActionObject);
        }

    };
    public void sendHumidityInstructions(HumidityAction humidityActionObject){
        if(value.equals("true")){
            httpPostMethod.sendPost(humidityAddressMock, humidityPortMock, humidityUrlMock, humidityActionObject);
        }else{
            httpPostMethod.sendPost(humidityAddress, humidityPort, humidityUrl, humidityActionObject);
        }

    };
    public void sendLightInstructions(LightAction lightActionObject){
        if(value.equals("true")){
            httpPostMethod.sendPost(lightAddressMock, lightPortMock, lightUrlMock, lightActionObject);
        }else{
            httpPostMethod.sendPost(lightAddress, lightPort, lightUrl, lightActionObject);
        }

    };
}
