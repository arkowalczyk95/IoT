package pl.esp8266.server.esp8266.model;

import org.springframework.stereotype.Component;

import javax.persistence.*;

@Entity
@Table(name = "espReads")

public class EspRead {

    @Id
    @GeneratedValue(generator = "reads_generator")
    @SequenceGenerator(
            name = "reads_generator",
            sequenceName = "reads_sequence",
            initialValue = 1
    )
    private Long readId;
    private float temperatureSht;
    private float temperatureBmp;
    private float pressure;
    private float humidity;
    private float uvIndex;
    private float lightFrequency;

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
