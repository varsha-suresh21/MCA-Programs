#include <stdio.h>
int main()
{
 int a[5],i,n,key,flag=0;
 printf("Enter the limit");
 scanf("%d",&n);
 printf("enter the elements");
 for(i=0;i<n;i++)
 {
  scanf("%d",&a[i]);
 }
 printf("Enter the elements to be searched");
 scanf("%d",&key);
 for(i=0;i<n;i++)
 {
  if(a[i]==key)
  {
   printf("element found at position %d",i+1);
   flag=1;
   }
   }
   if(flag==0)
   {
   printf("element is not found");
   }
   return 0;
   }
