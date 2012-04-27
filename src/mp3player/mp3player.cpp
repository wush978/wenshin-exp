/*
 * console.cpp
 *
 *  Created on: 2012/4/26
 *      Author: wush
 */

#include <windows.h>
#include <stdio.h>
#include <conio.h>

#include <iostream>

#include <fmod.hpp>
#include <fmod_errors.h>

void ERRCHECK(FMOD_RESULT result)
{
    if (result != FMOD_OK)
    {
        printf("FMOD error! (%d) %s\n", result, FMOD_ErrorString(result));
        exit(-1);
    }
}

int main(int argc, char* argv[])
{
	if (argc != 2) {
		printf("Usage: mp3player.exe <path to sound to play>");
		return 0;
	}
	const int argv_file_path(1);

	FMOD_RESULT result;
	FMOD::System *system;

	result = FMOD::System_Create(&system);
	if (result != FMOD_OK)
	{
	    printf("FMOD error! (%d) %s\n", result, FMOD_ErrorString(result));
	}

	result = system->init(100, FMOD_INIT_NORMAL, 0);
	if (result != FMOD_OK)
	{
	    printf("FMOD error! (%d) %s\n", result, FMOD_ErrorString(result));
	}

	FMOD::Sound *sound;
	result = system->createSound(argv[argv_file_path], FMOD_DEFAULT, 0, &sound);        // FMOD_DEFAULT uses the defaults.  These are the same as FMOD_LOOP_OFF | FMOD_2D | FMOD_HARDWARE.
	ERRCHECK(result);

	FMOD::Channel *channel;
	result = system->playSound(FMOD_CHANNEL_FREE, sound, false, &channel);
	ERRCHECK(result);

	std::cout << "Press return to quit." << std::endl;
	std::cin.get();

    /*
        Shut down
    */
    result = sound->release();
    ERRCHECK(result);
    result = system->close();
    ERRCHECK(result);
    result = system->release();
    ERRCHECK(result);

}


