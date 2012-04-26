
project( mp3player )

include_directories( BEFORE ${FMOD_INCLUDE} )
add_executable( mp3player mp3player.cpp )
target_link_libraries( mp3player ${FMOD_LIB} )