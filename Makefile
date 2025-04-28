all:
	./backend/init.sh
	cd frontend && make install && make serve