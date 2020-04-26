package pl.esp8266.server.esp8266.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import pl.esp8266.server.esp8266.model.EspRead;

@Service
public class CompareSensorValues {
    @Autowired
    AdjustTemperature adjustTemperature;
    @Autowired
    AdjustHumidity adjustHumidity;
    @Autowired
    AdjustLight adjustLight;

    public void createActions(EspRead sensorReads){
        adjustTemperature.checkTemperature(sensorReads);
        adjustHumidity.checkHumidity(sensorReads);
        adjustLight.checkLight(sensorReads);
    }
}
