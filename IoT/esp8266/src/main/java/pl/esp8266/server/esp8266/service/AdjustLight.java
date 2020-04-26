package pl.esp8266.server.esp8266.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.stereotype.Service;
import pl.esp8266.server.esp8266.adapter.EspAdapter;
import pl.esp8266.server.esp8266.model.EspRead;
import pl.esp8266.server.esp8266.model.LightAction;
import pl.esp8266.server.esp8266.model.LightRanges;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.repository.LightRangesRepository;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;

@Service
public class AdjustLight {
    @Autowired
    RoomModesRepository roomModesRepository;

    @Autowired
    @Qualifier("RoomModes")
    RoomModes roomModes;

    @Autowired(required=true)
    @Qualifier("LightAction")
    LightAction lightAction;

    @Autowired
    EspAdapter espAdapter;

    @Autowired
    @Qualifier("LightRangesRepository")
    LightRangesRepository lightRangesRepository;

    @Autowired
    @Qualifier("LightRanges")
    LightRanges lightRanges;

    public void checkLight (EspRead sensorReads){

        roomModes = roomModesRepository.findBySelected(true);
        int lightLevel = roomModes.getLightFrequency();
        lightRanges = lightRangesRepository.findByRangeNumber(lightLevel);
        boolean uvExceed = roomModes.getUvIndex() < sensorReads.getUvIndex();

        if (sensorReads.getLightFrequency() > lightRanges.getMaxFrequency())
        {
            //zmniejsz intensywnosc swiatla
            lightAction.setAction("decrease");
        }
        else if(sensorReads.getLightFrequency() < lightRanges.getMinFrequency())
        {
            //zwiększ natężenie swiatla
            lightAction.setAction("increase");
        }else{
            lightAction.setAction("doNothing");
        }
        espAdapter.sendLightInstructions(lightAction);

        if (uvExceed)
        {
            System.out.println("UV index safe limit exceeded! Use sunscreen cream!");
            espAdapter.sendLightInstructions(lightAction);
        }
    }
}