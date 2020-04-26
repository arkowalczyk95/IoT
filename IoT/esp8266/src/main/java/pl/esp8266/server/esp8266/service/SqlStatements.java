package pl.esp8266.server.esp8266.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.lang.Nullable;
import org.springframework.stereotype.Service;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;
import javax.transaction.Transactional;

@Service
public class SqlStatements {
    @Autowired
    RoomModesRepository roomModesRepository;
    @Autowired
    RoomModes roomModes;
    @Autowired
    Features features;
    @Autowired
    RoomModes roomModes2;


    @Transactional
    public void changeSelectedMode(String name)
    {
        roomModes = roomModesRepository.findByName(name);
        if(roomModes == null) {}else{
            int count = roomModes.getPopularity() + 1;
            roomModesRepository.updateRoomModesPopularity(name, count);
            roomModesRepository.updateRoomModesSelected();
            roomModesRepository.updateRoomModesSelect(name);
            roomModes2 = roomModesRepository.findByName("AVERAGE");
            if(checkForNull(roomModes2)=="true") {
                roomModes2 = features.calculateAverageSettings();
                roomModesRepository.save(roomModes2);
            }
            else{
                roomModes2 = features.calculateAverageSettings();
                roomModesRepository.updateRoomModesAverageMode(roomModes2.getHumidity(), roomModes2.getIsPublic(), roomModes2.getLightFrequency(), roomModes2.getName(),roomModes2.getOwner(), roomModes2.getPopularity(), roomModes2.isSelected(), roomModes2.getTemperature(), roomModes2.getUvIndex());
            }
        }
    }

    public void updateChosenMode(RoomModes roomModes)
    {
        if(roomModes.getName().equals("AVERAGE")||roomModes.getName().equals("EVENING")||roomModes.getName().equals("RELAX")||roomModes.getName().equals("WORK")||roomModes.getName().equals("FILM")||roomModes.getName().equals("DAY")||roomModes.getName().equals("NIGHT"))
        {}
        else{
            roomModesRepository.updateRoomMode(roomModes.getHumidity(), roomModes.getIsPublic(), roomModes.getLightFrequency(), roomModes.getName(), roomModes.getTemperature(), roomModes.getUvIndex());
        }
    }
    public String checkForNull(@Nullable RoomModes object){
        if (object == null){
            return "true";
        }
        else
            return "false";
    }

}
