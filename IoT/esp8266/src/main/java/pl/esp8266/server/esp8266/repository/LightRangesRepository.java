package pl.esp8266.server.esp8266.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Component;
import org.springframework.stereotype.Repository;
import org.springframework.transaction.annotation.Transactional;
import pl.esp8266.server.esp8266.model.EspRead;
import pl.esp8266.server.esp8266.model.LightRanges;

@Repository
@Component("LightRangesRepository")
public interface LightRangesRepository extends JpaRepository<LightRanges, Long> {
    LightRanges findByRangeNumber(int rangeNumber);

}
