
project( mp3player )

include_directories( BEFORE ${FMOD_INCLUDE} )

if (MSVC)
    add_executable( mp3player mp3player.cpp )
elseif(MINGW)
    add_executable( mp3player mp3player.c )
else()
    message(FATAL_ERROR "TODO")
endif()

target_link_libraries( mp3player ${FMOD_LIB} )