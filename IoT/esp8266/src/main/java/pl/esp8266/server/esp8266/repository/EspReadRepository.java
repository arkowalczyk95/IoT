package pl.esp8266.server.esp8266.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import pl.esp8266.server.esp8266.model.EspRead;

@Repository
public interface EspReadRepository extends JpaRepository<EspRead, Long> {
}
