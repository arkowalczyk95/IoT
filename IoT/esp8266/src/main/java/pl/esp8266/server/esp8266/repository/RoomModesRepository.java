package pl.esp8266.server.esp8266.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import pl.esp8266.server.esp8266.model.RoomModes;

@Repository
public interface RoomModesRepository extends JpaRepository<RoomModes, Long> {

    RoomModes findByName(String name);
    RoomModes findBySelected(Boolean selected);


}
