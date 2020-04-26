package pl.esp8266.server.esp8266.controller;


import com.sun.org.apache.xpath.internal.objects.XNull;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.bind.annotation.*;
import pl.esp8266.server.esp8266.model.EspRead;
import pl.esp8266.server.esp8266.model.LightRanges;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.repository.EspReadRepository;
import pl.esp8266.server.esp8266.repository.LightRangesRepository;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;
import pl.esp8266.server.esp8266.service.CompareSensorValues;
import pl.esp8266.server.esp8266.service.Features;


import java.util.Date;
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
    @Autowired
    EspRead espRead;
    @Autowired
    LightRangesRepository lightRangesRepository;
    @Autowired
    Features features;
    @Autowired
    List<LightRanges> lightRanges;


    @PostMapping(value = "/espRead")
    EspRead createEspRead(@RequestBody EspRead newEspRead) {
        Date date = new Date();
        LOG.info("[received data] humidity(%): " + newEspRead.getHumidity() + ", lightFrequency(Hz): " + newEspRead.getLightFrequency() + ", pressure(hPa): "+ newEspRead.getPressure() + ", uvIndex: " + newEspRead.getUvIndex() + ", tempBMP180: " + newEspRead.getTemperatureBmp() + ", tempSHT21: " +newEspRead.getTemperatureSht());
        newEspRead.setReadDate(date.getTime());
        espReadRepository.save(newEspRead);
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
    @GetMapping(value = "/espRead/recent")
    EspRead getRecentEspRead() throws Exception {
        Long maxDate = espReadRepository.returnMaxDate();
        espRead = espReadRepository.returnRecentEspRead(maxDate);
        lightRanges = lightRangesRepository.findAll();
        for(LightRanges lightRange: lightRanges){
            if(espRead.getLightFrequency() > lightRange.getMinFrequency() && espRead.getLightFrequency() < lightRange.getMaxFrequency())
         {
            espRead.setLightFrequency(lightRange.getRangeNumber());
         }
        }
        //dzialaj
        espRead.setHumidity(features.roundToDecimal(espRead.getHumidity(), 2));
        return espRead;

    }
}
