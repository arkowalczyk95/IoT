package pl.esp8266.server.esp8266.controller;


import com.sun.org.apache.xpath.internal.objects.XNull;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.bind.annotation.*;
import pl.esp8266.server.esp8266.model.EspRead;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.repository.EspReadRepository;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;
import pl.esp8266.server.esp8266.service.CompareSensorValues;


import java.util.List;







/**
 *To receive requests from esp8266
 *
**/
@RestController
@RequestMapping("/api")
public class RestEspChannel {
    private final static Logger LOG = LoggerFactory.getLogger(RestEspChannel.class);

    @Autowired
    EspReadRepository espReadRepository;
    @Autowired
    RoomModesRepository roomModesRepository;
    @Autowired
    CompareSensorValues compareSensorValues;

    @PostMapping(value = "/espRead")
    EspRead createEspRead(@RequestBody EspRead newEspRead) {
        LOG.info("[received data] humidity(%): " + newEspRead.getHumidity() + ", lightFrequency(Hz): " + newEspRead.getLightFrequency() + ", pressure(hPa): "+ newEspRead.getPressure() + ", uvIndex: " + newEspRead.getUvIndex() + ", tempBMP180: " + newEspRead.getTemperatureBmp() + ", tempSHT21: " +newEspRead.getTemperatureSht());
        compareSensorValues.createActions(newEspRead);
        return newEspRead;
    }
    @GetMapping(value = "/espRead")
    List<EspRead> getEspReads() {
        return espReadRepository.findAll();
    }

    @GetMapping(value = "/espRead/{id}")
    EspRead getEspRead(@PathVariable Long id) throws Exception {
        return espReadRepository.findById(id)
                .orElseThrow(() -> new Exception());
    }
}
