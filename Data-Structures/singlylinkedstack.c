#include <stdio.h>
#include <stdlib.h>
struct node{
int data;
struct node *link;
};

struct node *top = NULL;

void push(){
struct node *newnode;
newnode = (struct node*)malloc(sizeof(struct node));

if(newnode == NULL){
printf("\n NO Space Available \n");
return;
}

newnode -> link = NULL;

printf("\n Enter the element to insert:");
scanf("%d",&newnode->data);

if(top == NULL){
top = newnode;
}

else{
newnode->link = top;
top = newnode;
}

printf("\n %d Inserted Successfully",newnode->data);

}


 void pop(){
 struct node* temp = top;
 if(top == NULL){
 printf("\n STACK UNDERFLOW");
 return;
 }
 printf("\n %d is popped", temp->data);
 top = temp->link;
 free(temp);
 }
 
 
 
void peek(){
struct node *temp= top;
if(top == NULL){
printf("\n STACK UNDERFLOW");
}
 printf("\n Top element is %d",temp->data);
}
 
 
 
void display(){
struct node *temp= top;
if(top == NULL){
printf("\n NO Element");
return;
}
printf("\n Element in stack are:");
while(temp != NULL){
 printf("\t %d",temp->data);
 temp = temp->link;
 }
}
 

  void search(){
  struct node* temp = top;
  int key, found = 0;
  if(top == NULL){
  printf("\n STACK UNDERFLOW\n");
  return;
  }
  printf("\n Enter the element to search:\n");
  scanf("%d", &key);
  
  while(temp != NULL){
  if(temp->data == key){
  printf("\n %d Element Founded \n",temp->data);
  found = 1;
  }
  temp = temp->link;
  }
  if(!found){
  printf("\n Element NOT Founded");
   }
   }
   
   
void main(){
int choice;

do{
printf("\n----Stack Operation----\n");
printf("\n 1-> push() \n 2-> pop() \n 3-> peek() \n 4-> display() \n 5-> search() \n 6-> Exit");

printf("\n Enter the choice:");
scanf("%d",&choice);

switch(choice){

 case 1: push();
         break;
 case 2: pop();
         break;
 case 3: peek();
         break;
 case 4: display();
         break;
 case 5: search();
         break;
 case 6: printf("Exit");
 break;
 default:printf("Enter a valid choice");
 }
 }while(choice != 6);
 }
 
