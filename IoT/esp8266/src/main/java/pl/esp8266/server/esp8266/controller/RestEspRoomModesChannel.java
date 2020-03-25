package pl.esp8266.server.esp8266.controller;


import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import pl.esp8266.server.esp8266.model.EspRead;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.repository.EspReadRepository;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;

import java.util.List;


/**
 *To receive requests from esp8266
 *
**/
@RestController
@RequestMapping("/api")
public class RestEspRoomModesChannel {
    private final static Logger LOG = LoggerFactory.getLogger(RestEspRoomModesChannel.class);
    @Autowired
    private RoomModesRepository roomModesRepository;


    @GetMapping(value = "/modesId/{id}")
    RoomModes getRoomModes(@PathVariable Long id) throws Exception {
        return roomModesRepository.findById(id)
                .orElseThrow(() -> new Exception());
    }

    @GetMapping(value = "/modesName/{name}")
    RoomModes getRoomModes(@PathVariable String name) throws Exception {
        RoomModes roomModes = roomModesRepository.findByName(name);
        if(roomModes.getModeId()==null)
        {
            throw new Exception();
        }
        return roomModes;
        }

    @GetMapping(value = "/modes/selected")
    RoomModes getRoomModes(){return roomModesRepository.findBySelected(true);}





}
