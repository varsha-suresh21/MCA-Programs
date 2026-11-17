#include <stdio.h>
int main(){

int a[10],i,n,key,found=0;

printf("\n Enter the limit:");
scanf("%d",&n);
printf("\n Enter the Elements:");

for(i=0; i<n; i++)
{
 scanf("%d",&a[i]);
 }
 
 printf("\n Enter the element to be searched:");
 scanf("%d",&key);
 
 for(i=0; i<n; i++)
 {
 if(a[i]==key){
 
 printf("\n The element searched is at position %d",i+1);
 found = 1;
 break;
 }
 
  }
 if(found==0)
 {
 printf("\n element not founded");
 }
 return 0;
 }
 
