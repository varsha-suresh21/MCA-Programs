#include <stdio.h>
#include <stdlib.h>

struct node{
            int data;
            struct node *link;
            };
            
struct node*head = NULL;

void insertFirst(){
                   struct node *newnode;
                   newnode = (struct node*)malloc(sizeof(struct node));
                   
                   if (newnode == NULL){
                                        printf("\n NO Space Available\n");
                                        return;
                                        
                                       }
                                       
                   newnode->link = NULL;
                   printf("\n Enter the value to be insert to front :  \n");
                   scanf("%d",&newnode->data);
                   if(head == NULL){
                                   head = newnode;
                                  }
                                  
                   else{
                        newnode->link = head;
                        head = newnode;
                       }
                       printf("\n Element inserted %d \n", newnode->data);
                       }
                     
void insertLast() {
    struct node *temp = head, *newnode;
    newnode = (struct node*)malloc(sizeof(struct node));
    if (newnode == NULL) {
        printf("\n NO Space Available \n");
        return;
    }
    
    
    printf("\n Enter the element to be insert last: \n");
    scanf("%d", &newnode->data);
    newnode->link = NULL; 
    

    if (head == NULL) {

        head = newnode;
    } else {

        while (temp->link != NULL) {
            temp = temp->link;
        }

        temp->link = newnode; 
    }
    
    printf("\n Element inserted successfully: %d\n", newnode->data);
}

		                                  
void insertLocation(){
			int key;
			struct node *temp = head, *newnode;
			newnode =(struct node*)malloc(sizeof(struct node));
			if(newnode == NULL){
					     printf("\n NO Space Available \n");
					     return;
					    }
	
 			newnode->link = NULL;
 			if(head == NULL){
 			printf("\n List Empty \n");
 			return;
 			}
 			printf("\n Enter the key were after you want to add element: \n");
 			scanf("%d",&key);
 			while(temp != NULL && temp ->data != key){
 			                                          temp = temp->link;
 			                                         }
 			                                         
 			if(temp == NULL){
 					  printf("\n Value Not Exist \n");
 					  return;
 					 }	
 					 printf("Enter the element to be inserted: \n");
 					 scanf("%d",&newnode->data);
 					 newnode->link = temp->link;
 					 temp->link = newnode;
 					 printf("Value inserted successfully %d", newnode->data);
 					 }
 		
void deleteFirst(){
		    struct node *temp = head;
		    if(head == NULL){
		                     printf("\n List Empty\n");
		                     return;
		                    }
		                    head = temp->link;
		                    printf("\n Value deleted %d \n",temp->data);
		                    free(temp);
		                    }
		                    
void deleteLast(){
		   struct node *temp = head , *prev = NULL;
		   if(head == NULL){
		    		     printf("\n Empty List \n");
		    		     return;
		    		    }
		    		    
		   if(temp->link == NULL){
		    		    printf("\n Valid %d deleted \n", temp->data);
		    		    head = NULL;
		    		    free(temp);
		    		    return;
		    		    }
		   while(temp->link != NULL){
		                             prev = temp;
		                             temp = temp->link;
		                            }
		                            printf("\n Valid %d deleted \n", temp->data);
		                            prev -> link = NULL;
		                            free(temp);
		                            }
		                        
void deleteLocation(){
                      int key;
                      struct node *temp = head ,*prev = NULL;
                      if(head == NULL){
                                       printf("\n Empty List \n");
                                       return;
                                      }
                                      printf("\n Enter the key that you want to delete: \n");
                                      scanf("%d",&key);
                      if(temp->data == key){
                                             head = temp->link;
                                             printf("\n Value %d is deleted \n", temp->data);
                                             free(temp);
                                             return;
                                           }
                      while(temp != NULL && temp->data != key){
                                                               prev = temp;
                                                               temp = temp->link;
                                                              }
                      if(temp == NULL){
                                       printf("\n Value Not Exist \n");
                                       return;
                                      }
                                      prev->link = temp->link;
                                      printf("Value %d is deleted", temp->data);
                                      free(temp);
                                      }
                                      
void search(){
 	      struct node *temp = head;
 	      int pos = 0, found = 0, val;
 	      if(head == NULL){
 	                       printf("\n Empty List \n");
 	                       return;
 	                      }
 	      printf("\n Enter the value to search:");
 	      scanf("%d",&val);
 	      while(temp != NULL){
 	                          if(temp->data == val){
 	                                                printf("%d value found at location %d \n", temp->data, pos+1);
 	                                                found = 1;
 	                                               }
 	                                               pos++;
 	                                               temp = temp->link;
 	                                               }
 	                          if(!found){
 	                                     printf("Value %d not exist", val);
 	                                     }
 	                                     }
 	                                     
 	                                     
void display(){
               struct node *temp = head;
               if(temp == NULL){
                                printf("\n List Empty ");
                                return;
                               }
                               printf("\n Elements in the List: \n");
                               while(temp != NULL){
                                                   printf("%d",temp->data);
                                                   temp = temp->link;
                                                  }
              }
              
              
void main(){
            int choice;
            printf("\n SINGLY LINKED LIST \n");
            do{
               printf("\n 1-> InsertFirst \n 2-> InsertLast \n 3-> InsertLocation \n 4-> DeleteFirst \n 5-> DeleteLast \n 6-> DeleteLocation \n 7-> Search \n 8-> Display \n 9-> Exit");
                
                printf("\n Enter the choice: \n");
                scanf("%d",&choice);
                
                switch(choice){
                             
                             case 1: insertFirst();
                                     break;
                                     
                             case 2: insertLast();
                                     break;
                                     
                             case 3: insertLocation();
                                     break;
                                     
                             case 4: deleteFirst();
                                     break;
                                     
                             case 5: deleteLast();
                                     break;
                                     
                             case 6: deleteLocation();
                                     break;
                                     
                             case 7: search();
                                     break;
                                     
                             case 8: display();
                                     break;
                                     
                             case 9: printf("\n Exit \n");
                                     exit(0);
                                     
                             default :
                                      printf("\n INVALID CHOICE \n");
                                      }
                                      
                               }while(choice != 9);
                               }
      
                                                                                                                      	                          		
		   	                       
