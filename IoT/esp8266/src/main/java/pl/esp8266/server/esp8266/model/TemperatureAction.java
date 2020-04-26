package pl.esp8266.server.esp8266.model;

import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.stereotype.Component;

import javax.persistence.*;

@Component("TemperatureAction")
public class TemperatureAction {

    private String action;

    public String getAction() {
        return action;
    }

    public void setAction(String action) {
        this.action = action;
    }



}
