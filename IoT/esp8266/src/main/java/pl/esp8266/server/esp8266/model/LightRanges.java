package pl.esp8266.server.esp8266.model;

import org.springframework.stereotype.Component;

import javax.persistence.*;

@Entity
@Table(name = "lightRanges")
@Component("LightRanges")
public class LightRanges {

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

    private int rangeNumber;
    private float maxFrequency;
    private float minFrequency;

    public int getRangeNumber() {
        return rangeNumber;
    }

    public void setRangeNumber(int rangeNumber) {
        this.rangeNumber = rangeNumber;
    }

    public float getMaxFrequency() {
        return maxFrequency;
    }

    public void setMaxFrequency(float maxFrequency) {
        this.maxFrequency = maxFrequency;
    }

    public float getMinFrequency() {
        return minFrequency;
    }

    public void setMinFrequency(float minFrequency) {
        this.minFrequency = minFrequency;
    }
}
