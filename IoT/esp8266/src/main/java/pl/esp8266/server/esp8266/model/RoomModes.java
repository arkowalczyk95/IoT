package pl.esp8266.server.esp8266.model;

import org.hibernate.validator.constraints.UniqueElements;
import org.springframework.stereotype.Component;

import javax.persistence.*;

@Entity
@Table(name = "roomModes")
@Component("RoomModes")
public class RoomModes {

    @Id
    @GeneratedValue(generator = "reads_generator")
    @SequenceGenerator(
            name = "reads_generator",
            sequenceName = "reads_sequence",
            initialValue = 1
    )
    private Long modeId;


    @Column(unique=true)
    private String name;
    private float temperature;
    private float humidity;
    private float uvIndex;
    private float lightFrequency;
    private boolean selected;

    public boolean isSelected() {
        return selected;
    }

    public void setSelected(boolean selected) {
        this.selected = selected;
    }

    public Long getModeId() {
        return modeId;
    }

    public void setModeId(Long modeId) {
        this.modeId = modeId;
    }
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }



    public float getTemperature() {
        return temperature;
    }

    public void setTemperature(float temperature) {
        this.temperature = temperature;
    }

    public float getHumidity() {
        return humidity;
    }

    public void setHumidity(float humidity) {
        this.humidity = humidity;
    }

    public float getUvIndex() {
        return uvIndex;
    }

    public void setUvIndex(float uvIndex) {
        this.uvIndex = uvIndex;
    }

    public float getLightFrequency() {
        return lightFrequency;
    }

    public void setLightFrequency(float lightFrequency) {
        this.lightFrequency = lightFrequency;
    }


}
