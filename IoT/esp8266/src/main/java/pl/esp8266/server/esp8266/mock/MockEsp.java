package pl.esp8266.server.esp8266.mock;


import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import pl.esp8266.server.esp8266.controller.RestEspChannel;
import pl.esp8266.server.esp8266.model.TemperatureAction;
import pl.esp8266.server.esp8266.model.HumidityAction;
import pl.esp8266.server.esp8266.model.LightAction;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@RestController
@RequestMapping("/mock/esp")
public class MockEsp {

    @PostMapping(value = "/temperature")
    TemperatureAction getTemperatureAction(@RequestBody TemperatureAction temperatureAction) {
        Logger LOG = LoggerFactory.getLogger(TemperatureAction.class);
        LOG.info("received action from server: " + temperatureAction.getAction());
        return temperatureAction;
    }    @PostMapping(value = "/humidity")
    HumidityAction getHumidityAction(@RequestBody HumidityAction humidityAction) {
        Logger LOG = LoggerFactory.getLogger(HumidityAction.class);
        LOG.info("received action from server: " + humidityAction.getAction());
        return humidityAction;
    }    @PostMapping(value = "/light")
    LightAction getLightAction(@RequestBody LightAction lightAction) {
        Logger LOG = LoggerFactory.getLogger(LightAction.class);
        LOG.info("received action from server: " + lightAction.getAction());
        return lightAction;
    }
}
