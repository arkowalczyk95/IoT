package pl.esp8266.server.esp8266.model;

import org.springframework.stereotype.Component;

import javax.persistence.*;
import java.util.Date;

@Entity
@Table(name = "espReads")
@Component("EspRead")
public class EspRead {

    public Long getReadId() {
        return readId;
    }

    public void setReadId(Long readId) {
        this.readId = readId;
    }

    @Id
    @GeneratedValue(generator = "reads_generator")
    @SequenceGenerator(
            name = "reads_generator",
            sequenceName = "reads_sequence",
            initialValue = 1
    )
    private Long readId;
    private Long readDate;
    private float temperatureSht;
    private float temperatureBmp;
    private float pressure;
    private float humidity;
    private float uvIndex;
    private float lightFrequency;

    public Long getReadDate() {
        return readDate;
    }

    public void setReadDate(Long readDate) {
        this.readDate = readDate;
    }
    public float getTemperatureSht() {
        return temperatureSht;
    }

    public void setTemperatureSht(float temperatureSht) {
        this.temperatureSht = temperatureSht;
    }

    public float getTemperatureBmp() {
        return temperatureBmp;
    }

    public void setTemperatureBmp(float temperatureBmp) {
        this.temperatureBmp = temperatureBmp;
    }

    public float getPressure() {
        return pressure;
    }

    public void setPressure(float pressure) {
        this.pressure = pressure;
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
