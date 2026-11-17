include <stdio.h>
#define MAX 1000
int parent [MAX];
void initialize(int n){
	for(int 1i=0; i<n; i++)
		{
	         parent[i] = i;
	        }
	        }
	int find(int x){
		while (x != parent[x]){
		 x = parent[x];
		 }
		 return x;
		 }
		 
void union-set(int x, inty){
	int rootX = find(x);
	int rootY = find(y);
	if(rootX != rootY){
	     parent[rootX] = rootY;
	     }
	    }
	    int Connected(int x, int y){
	    	return find(x) == find(y);
	    	
	    	}
	    	
int main(){
	int n = 10
	initialize(n);
	union-set(1,2);
	union-set(3,4);
	union-set(2,3);
	printf("Are 1 and 4 connected ? %s \n", Connected(1,4) ? "Yes" : "No");
	printf("Are 1 and 5 connected ? %s \n", Connected(1,5) ? "Yes" : "No");
	return 0;
	}
	
