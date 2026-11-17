#include <stdio.h>
int main()
{
int mark;
printf("enter the mark : ");
scanf("%d",&mark);
if(mark>90)
 {
 printf("A Grade");
 }
 else if(mark>80)
  { 
   printf("B Grade");
   }
   else if(mark>50)
    {
     printf("C Grade");
     }
     else
     {
      printf("Failed");
     }
   }
