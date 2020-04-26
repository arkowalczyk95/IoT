package pl.esp8266.server.esp8266.controller;



import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.web.bind.annotation.*;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;
import pl.esp8266.server.esp8266.service.SqlStatements;
import java.util.List;
import java.util.Optional;


/**
 *To receive requests from esp8266
 *
**/
@RestController
@RequestMapping("/api")
public class RestEspRoomModesChannel {
    private final static Logger LOG = LoggerFactory.getLogger(RestEspRoomModesChannel.class);
    @Autowired
    @Qualifier("RoomModesRepository")
    private RoomModesRepository roomModesRepository;
    @Autowired
    Optional<RoomModes> roomModes;
    @Autowired
    SqlStatements sqlStatements;

    @GetMapping(value = "/modesId/{id}")
    RoomModes getRoomModes(@PathVariable Long id) throws Exception {
        return roomModesRepository.findById(id)
                .orElseThrow(() -> new Exception());
    }
    @GetMapping(value = "/modesName/{name}")
    void changeRoomMode(@PathVariable String name) throws Exception {
        LOG.info("RETURN roomMode: " + name);
        sqlStatements.changeSelectedMode(name);
        }
    @GetMapping(value = "/modes/selected")
    RoomModes getRoomModes(){
        LOG.info("RETURN selected roomMode");
        return roomModesRepository.findBySelected(true);}
    @GetMapping(value = "/modes/all")
    List<RoomModes> getAllRoomModes(){
        LOG.info("RETURN all roomModes");
        return roomModesRepository.findAll();}
    @PostMapping(value ="/modes/create")
    RoomModes createRoomMode(@RequestBody RoomModes roomModes){
        LOG.info("CREATE roomMode: " + roomModes.getName());
        return roomModesRepository.save(roomModes);
    }
    @PostMapping(value ="/modes/update")
    RoomModes updateRoomMode(@RequestBody RoomModes roomModes){
        LOG.info("UPDATE roomMode: " + roomModes.getName());
       sqlStatements.updateChosenMode(roomModes);
       return roomModes;}
    @DeleteMapping(value = "/modes/delete/{name}")
    void deleteMode(@PathVariable String name) {
        LOG.info("DELETE roomMode: " + name);
        RoomModes roomModes = roomModesRepository.findByName(name);
        roomModesRepository.deleteById(roomModes.getModeId());
    }





}
