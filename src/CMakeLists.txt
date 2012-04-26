cmake_minimum_required( VERSION 2.8 )

# set include variable
set( VENDOR "${CMAKE_SOURCE_DIR}/vendor" )
set( FMOD_INCLUDE "${VENDOR}/Fmod/api/inc" )

# set linking variable
set( FMOD_LIB_DIR "${VENDOR}/Fmod/api/lib" )

if(MSVC)
    find_library( FMOD_LIB fmodex_vc ${FMOD_LIB_DIR} )
endif()

add_subdirectory( console )