# Available endpoints

- [Get Availability](GetAvailability.md)

	The Availability Request message requests Flight Availability for a city pair on a specific date for a specific number and type of passengers. Calendar with best price of each day in a week and full flight list with their price depending on cabin will be provided.

- [Get Timetable](GetTimetable.md)

	This method retrieves schedule info. It lists all flights in requested route and operation days in a week.
 
- [Get Port List](GetPortList.md)

	Lists all ports in details.
	
- [Get Fare Family List](GetFareFamilyList.md)

	This is a lookup method that gives fare family list to be used for getAvailability request. The output changes depending on ports location (domestic or international) and ticket type (award ticket or not). 	
	
- [Retrieve Reservation Detail](RetrieveReservationDetail.md)

	This method returns the detailed information of the reservations created through our reservation system in XML format. It covers reservations made from all sales channels.
	
- [Calculate Flight Miles](CalculateFlightMiles.md)

	Calculates miles for flight.
	
- [Calculate Award Miles With Tax](CalculateAwardMilesWithTax.md)

	Calculates award miles with tax.
	
