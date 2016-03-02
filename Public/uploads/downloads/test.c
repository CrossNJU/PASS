#include <stdio.h>

int main(){
	int x[3];
	x[1]=0x61616161;
	x[0]=0x61610000;
	x[2]=0;
	printf("%s\n",x);
}