package pl.esp8266.server.esp8266.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Component;
import org.springframework.stereotype.Repository;
import pl.esp8266.server.esp8266.model.RoomModes;

import org.springframework.transaction.annotation.Transactional;

@Repository
@Component("RoomModesRepository")
public interface RoomModesRepository extends JpaRepository<RoomModes, Long> {


  RoomModes findBySelected(Boolean selected);
  RoomModes findByName(String name);

  @Modifying(clearAutomatically = true)
  @Transactional
  @Query("UPDATE RoomModes rm set rm.selected = 'f'")
  int updateRoomModesSelected();

  @Modifying(clearAutomatically = true)
  @Transactional
  @Query("UPDATE RoomModes rm set rm.selected = 't' where rm.name = :name")
  int updateRoomModesSelect(@Param("name") String name);

  @Modifying(clearAutomatically = true)
  @Transactional
  @Query("UPDATE RoomModes rm set rm.popularity = :popularity where rm.name = :name")
  void updateRoomModesPopularity(@Param("name") String name, @Param("popularity") int popularity);

  @Modifying(clearAutomatically = true)
  @Transactional
  @Query("UPDATE RoomModes rm set rm.humidity = :humidity, rm.isPublic = :isPublic, rm.lightFrequency = :lightFrequency, rm.owner = :owner, rm.popularity = :popularity, rm.selected = :selected, rm.temperature = :temperature, rm.uvIndex = :uvIndex  where rm.name = :name")
  void updateRoomModesAverageMode( @Param("humidity") float humidity, @Param("isPublic") boolean isPublic, @Param("lightFrequency") int lightFrequency, @Param("name") String name, @Param("owner") String owner, @Param("popularity") int popularity,  @Param("selected") boolean selected, @Param("temperature") float temperature, @Param("uvIndex") float uvIndex );

  @Modifying(clearAutomatically = true)
  @Transactional
  @Query("UPDATE RoomModes rm set rm.humidity = :humidity, rm.isPublic = :isPublic, rm.lightFrequency = :lightFrequency, rm.temperature = :temperature, rm.uvIndex = :uvIndex  where rm.name = :name")
  void updateRoomMode( @Param("humidity") float humidity, @Param("isPublic") boolean isPublic, @Param("lightFrequency") int lightFrequency, @Param("name") String name,   @Param("temperature") float temperature, @Param("uvIndex") float uvIndex );





}
