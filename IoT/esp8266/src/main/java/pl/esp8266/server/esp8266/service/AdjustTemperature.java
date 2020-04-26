package pl.esp8266.server.esp8266.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.stereotype.Service;
import pl.esp8266.server.esp8266.model.EspRead;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.model.TemperatureAction;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;
import pl.esp8266.server.esp8266.adapter.EspAdapter;

@Service
public class AdjustTemperature  {

    @Autowired
    RoomModesRepository roomModesRepository;

    @Autowired
    @Qualifier("RoomModes")
    RoomModes roomModes;

    @Autowired(required=true)
    @Qualifier("TemperatureAction")
    TemperatureAction temperatureAction;

    @Autowired
    EspAdapter espAdapter;

    public void checkTemperature (EspRead sensorReads){


        roomModes = roomModesRepository.findBySelected(true);
        if (roomModes.getTemperature()!=(sensorReads.getTemperatureSht() + sensorReads.getTemperatureBmp())/2)
        {
            float value = roomModes.getTemperature() - (sensorReads.getTemperatureSht() + sensorReads.getTemperatureBmp())/2;
            if(value > 0.0f){
                //zwiększ temp
                temperatureAction.setAction("increase");

            }else if (value < 0.0f){
                //zmniejsz temp
                temperatureAction.setAction("decrease");
                }
        }else {
            temperatureAction.setAction("doNothing");
        }
        espAdapter.sendTemperatureInstructions(temperatureAction);
    }
}
