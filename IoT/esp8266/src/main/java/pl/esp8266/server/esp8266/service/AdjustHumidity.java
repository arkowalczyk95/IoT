package pl.esp8266.server.esp8266.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.stereotype.Service;
import pl.esp8266.server.esp8266.model.EspRead;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.model.HumidityAction;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;
import pl.esp8266.server.esp8266.adapter.EspAdapter;

@Service
public class AdjustHumidity {
    @Autowired
    RoomModesRepository roomModesRepository;
    @Autowired
    @Qualifier("RoomModes")
    RoomModes roomModes;
    @Autowired
    @Qualifier("HumidityAction")
    HumidityAction humidityAction;
    @Autowired
    @Qualifier("EspAdapter")
    EspAdapter espAdapter;

    public void checkHumidity(EspRead sensorReads){
        roomModes = roomModesRepository.findBySelected(true);
        if (roomModes.getHumidity()!=sensorReads.getHumidity())
        {
            float value = roomModes.getHumidity() - sensorReads.getHumidity();
            if(value > 0.0f){
                humidityAction.setAction("increase");

            }else if (value < 0.0f){
                humidityAction.setAction("decrease");
            }
        }else{
            humidityAction.setAction("doNothing");
        }
        espAdapter.sendHumidityInstructions(humidityAction);
    }
}
