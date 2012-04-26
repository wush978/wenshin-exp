
project( console )

add_executable( console WIN32 console.cpp )
target_link_libraries( console ${FMOD_LIB} )