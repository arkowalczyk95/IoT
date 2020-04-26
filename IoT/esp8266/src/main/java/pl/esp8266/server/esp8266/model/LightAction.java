package pl.esp8266.server.esp8266.model;

import org.springframework.stereotype.Component;

@Component("LightAction")
public class LightAction {
    private String action;

    public String getAction() {
        return action;
    }

    public void setAction(String action) {
        this.action = action;
    }
}
