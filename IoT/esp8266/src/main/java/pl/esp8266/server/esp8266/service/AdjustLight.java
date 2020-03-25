
package pl.esp8266.server.esp8266.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import pl.esp8266.server.esp8266.model.EspRead;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;

@Service
public class AdjustLight {
    @Autowired
    RoomModesRepository roomModesRepository;
    RoomModes roomModes;
    public void checkLight(EspRead sensorReads){
        roomModes = roomModesRepository.findBySelected(true);
        //TODO : create and implement logic for light values
        //TODO : build json
        System.out.println("Not sure what to do with light");

    }
}
