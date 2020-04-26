package pl.esp8266.server.esp8266.model;

import net.bytebuddy.implementation.bind.annotation.Default;
import org.hibernate.validator.constraints.UniqueElements;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
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

    @Value("0")
    private int popularity;

    @Column(unique=true)
    private String name;
    private String owner;
    private boolean isPublic;
    private float temperature;
    private float humidity;
    private float uvIndex;
    private int lightFrequency;
    private boolean selected;

    public int getLightFrequency() {
        return lightFrequency;
    }

    public void setLightFrequency(int lightFrequency) {
        this.lightFrequency = lightFrequency;
    }

    public boolean isPublic() {
        return isPublic;
    }

    public void setPublic(boolean aPublic) {
        isPublic = aPublic;
    }

    public boolean getIsPublic() {
        return isPublic;
    }

    public void setIsPublic(boolean aPublic) {
        isPublic = aPublic;
    }
    public int getPopularity() {
        return popularity;
    }

    public void setPopularity(int popularity) {
        this.popularity = popularity;
    }
    public String getOwner() {
        return owner;
    }

    public void setOwner(String owner) {
        this.owner = owner;
    }


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



}
