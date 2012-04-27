/*===============================================================================================
 PlaySound Example
 Copyright (c), Firelight Technologies Pty, Ltd 2004-2011.

 This example shows how to simply load and play multiple sounds.  This is about the simplest
 use of FMOD.
 This makes FMOD decode the into memory when it loads.  If the sounds are big and possibly take
 up a lot of ram, then it would be better to use the FMOD_CREATESTREAM flag so that it is
 streamed in realtime as it plays.
 ===============================================================================================*/
#include <windows.h>
#include <stdio.h>
#include <conio.h>

#include "fmod.h"
#include "fmod_errors.h"

void ERRCHECK(FMOD_RESULT result) {
	if (result != FMOD_OK) {
		printf("FMOD error! (%d) %s\n", result, FMOD_ErrorString(result));
		exit(-1);
	}
}

int main(int argc, char *argv[]) {

	if (argc != 2) {
		printf("Usage: mp3player.exe <path to sound to play>");
		return 0;
	}
	const int argv_file_path = 1;

	FMOD_SYSTEM *system;
	FMOD_SOUND *sound;
	FMOD_CHANNEL *channel = 0;
	FMOD_RESULT result;
	int key;
	unsigned int version;

	/*
	 Create a System object and initialize.
	 */
	result = FMOD_System_Create(&system);
	ERRCHECK(result);

	result = FMOD_System_GetVersion(system, &version);
	ERRCHECK(result);

	if (version < FMOD_VERSION) {
		printf(
				"Error!  You are using an old version of FMOD %08x.  This program requires %08x\n",
				version, FMOD_VERSION);
		return 0;
	}

	result = FMOD_System_Init(system, 32, FMOD_INIT_NORMAL, NULL);
	ERRCHECK(result);

	result = FMOD_System_CreateSound(system, argv[argv_file_path],
			FMOD_HARDWARE, 0, &sound);
	ERRCHECK(result);

	result = FMOD_System_PlaySound(system, FMOD_CHANNEL_FREE,
			sound, 0, &channel);
	ERRCHECK(result);

	printf("Press RETURN to top and quit.");
	int i;
	scanf("%d", &i);

	/*
	 Shut down
	 */
	result = FMOD_Sound_Release(sound);
	ERRCHECK(result);
	result = FMOD_System_Close(system);
	ERRCHECK(result);
	result = FMOD_System_Release(system);
	ERRCHECK(result);

	return 0;
}

