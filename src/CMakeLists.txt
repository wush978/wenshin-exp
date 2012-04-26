cmake_minimum_required( VERSION 2.8 )

# set output location

set(CMAKE_RUNTIME_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/bin)
set(CMAKE_LIBRARY_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/lib)
set(CMAKE_ARCHIVE_OUTPUT_DIRECTORY ${CMAKE_BINARY_DIR}/lib)

# compile and linking

## set include variable
set( VENDOR "${CMAKE_SOURCE_DIR}/../vendor" )
set( FMOD_ROOT "${VENDOR}/Fmod/api" )
set( FMOD_INCLUDE "${FMOD_ROOT}/inc" )

## set linking variable
set( FMOD_LIB_DIR "${FMOD_ROOT}/lib" )

if(MSVC)
    message("This is MSVC")
    find_library( FMOD_LIB fmodex_vc ${FMOD_LIB_DIR} )
else()
    MESSAGE(FATAL_ERROR "TODO")
endif()

## set dll
if(MSVC)
    set( FMOD_DLL "${FMOD_ROOT}/fmodex.dll" )
else()
    MESSAGE(FATAL_ERROR "TODO")
endif()

## copy dll
file(INSTALL ${FMOD_DLL} DESTINATION ${CMAKE_RUNTIME_OUTPUT_DIRECTORY})

# add projects

add_subdirectory( mp3player )

# test

## set resources

set( TEST_ROOT "${CMAKE_SOURCE_DIR}/../test" )
set( TEST_FILE_NAME "AD100301.MP3" )
find_file( TEST_MP3 ${TEST_FILE_NAME} PATH ${TEST_ROOT} )

if(NOT TEST_MP3)
    message( "Starting download.." )
    file(DOWNLOAD "http://dl.dropbox.com/u/11900271/${TEST_FILE_NAME}" "${TEST_ROOT}/${TEST_FILE_NAME}" LOG "${TEST_ROOT}/download.log" )
endif()

## add tests

enable_testing()

add_test(mp3player1 "${CMAKE_RUNTIME_OUTPUT_DIRECTORY}/mp3player.exe" ${TEST_MP3})