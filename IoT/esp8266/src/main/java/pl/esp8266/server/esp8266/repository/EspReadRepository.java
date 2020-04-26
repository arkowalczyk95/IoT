package pl.esp8266.server.esp8266.repository;

import org.springframework.data.domain.Page;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Component;
import org.springframework.stereotype.Repository;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import pl.esp8266.server.esp8266.model.EspRead;

@Repository
public interface EspReadRepository extends JpaRepository<EspRead, Long> {

    @Transactional
    @Query(value = "select max(er.readDate) from EspRead er")
    Long returnMaxDate();

    @Transactional
    @Query(value = "select er from EspRead er where er.readDate = :readDate")
    EspRead returnRecentEspRead(@Param("readDate") Long readDate);

}
