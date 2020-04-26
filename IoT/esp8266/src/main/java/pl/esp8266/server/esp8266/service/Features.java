package pl.esp8266.server.esp8266.service;

import java.lang.Math;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import pl.esp8266.server.esp8266.model.RoomModes;
import pl.esp8266.server.esp8266.repository.RoomModesRepository;

import java.util.List;

@Service
public class Features {
    @Autowired
    RoomModesRepository roomModesRepository;
    @Autowired
    RoomModes roomModes2;

    float temperature = 0.0f;
    float humidity = 0.0f;
    float uvIndex = 0.0f;
    //    float freq_min = 0.0f;
    //    float freq_max = 0.0f;
    int lightLevel = 0;

    public float roundToDecimal(float num, int dec) {
        float multi = (float) Math.pow(10, dec);
        float temp = Math.round(num * multi);
        return temp / multi;
    }

    public RoomModes calculateAverageSettings(){
        int countSeq=0;

        List<RoomModes> roomModes=roomModesRepository.findAll();
        for(RoomModes roomModes1: roomModes){
            if(!roomModes1.getName().equals("AVERAGE")) {
                if(roomModes1.getPopularity()!=0){
                    temperature = temperature + roundToDecimal(roomModes1.getTemperature() * roomModes1.getPopularity(), 2);
                    humidity = humidity + roundToDecimal(roomModes1.getHumidity()  * roomModes1.getPopularity(), 1);
                    uvIndex = uvIndex + roomModes1.getUvIndex()  * roomModes1.getPopularity();
//                  String numbers [] = roomModes1.getLightFrequency().split("-");
//                  freq_min = Float.parseFloat(numbers[0])  * roomModes1.getPopularity() + freq_min;
//                  freq_max = Float.parseFloat(numbers[1])  * roomModes1.getPopularity() + freq_max;
                    lightLevel = lightLevel + Math.round(roomModes1.getLightFrequency() * roomModes1.getPopularity());
                    countSeq = countSeq + roomModes1.getPopularity();
                }
            }
        }

        float count = (float) countSeq;
        roomModes2.setTemperature(roundToDecimal(temperature/count, 2));
        roomModes2.setHumidity(roundToDecimal(humidity/count, 1));
        roomModes2.setUvIndex(uvIndex/count);
        roomModes2.setLightFrequency(lightLevel/(int)count);
        roomModes2.setName("AVERAGE");
        roomModes2.setOwner("all");
        roomModes2.setPopularity(0);
        roomModes2.setIsPublic(true);

        //reset for some reason it doesnt
        temperature = 0;
        humidity = 0;
        uvIndex = 0;
        lightLevel = 0;
        return roomModes2;
    }


}