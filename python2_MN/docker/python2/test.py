import matlab.engine
import matlab

# print(matlab.solve([[1, 0, 0], [1, 1, 0], [1, 1, 1]], [1, 2, 3]))

eng = matlab.engine.start_matlab()
eng.workspace['A'] = '[1, 0, 0; 1, 1, 0; 1, 1, 1]' # [[1, 0, 0], [1, 1, 0], [1, 1, 1]]
eng.workspace['b'] = '[1; 2; 3]' # [[1],[2],[3]]
ev = '''A = [1, 0, 0; 1, 1, 0; 1, 1, 1];
b = [1; 2; 3];
x_ref = A \ b;
[m, n] = size(A); 
L=eye(n); 
P=eye(n);
U=A;
   
for k=1:m-1
   [ pivot ind]=max(abs(U(k:m,k)));
   ind = ind+k-1;
   
   U([k,ind],k:m)=U([ind,k],k:m);
   L([k,ind],1:k-1)=L([ind,k],1:k-1);
   P([k,ind],:)=P([ind,k],:);
   
   for j=k+1:m
       L(j,k)=U(j,k)/U(k,k);
       U(j,k:m)=U(j,k:m)-L(j,k)*U(k,k:m);
   end
end
     
x = (U \ (L\(P * b)));
norm(x - x_ref);
'''
eng.eval(ev,nargout=0)
mpi = str(eng.workspace['x'])
mpi = mpi.replace('[', '')
mpi = mpi.replace(']', '')
mpi = mpi.replace(' ', '')
mpi = mpi.split(',')
mpi = [float(i) for i in mpi]

print(mpi)
print(type(mpi[0]))


