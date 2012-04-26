cmake_minimum_required( VERSION 2.8 )

# set output location

set(CMAKE_RUNTIME_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/bin)
set(CMAKE_LIBRARY_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/lib)
set(CMAKE_ARCHIVE_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/lib)

# set include variable
set( VENDOR "${CMAKE_SOURCE_DIR}/../vendor" )
set( FMOD_ROOT "${VENDOR}/Fmod/api" )
set( FMOD_INCLUDE "${FMOD_ROOT}/inc" )

# set linking variable
set( FMOD_LIB_DIR "${FMOD_ROOT}/lib" )

if(MSVC)
    message("This is MSVC")
    find_library( FMOD_LIB fmodex_vc ${FMOD_LIB_DIR} )
else()
    MESSAGE(FATAL_ERROR "TODO")
endif()

# set dll
if(MSVC)
    set( FMOD_DLL "${FMOD_ROOT}/fmodex.dll" )
else()
    MESSAGE(FATAL_ERROR "TODO")
endif()

#copy dll
file(INSTALL ${FMOD_DLL} DESTINATION ${CMAKE_RUNTIME_OUTPUT_DIRECTORY})

add_subdirectory( console )