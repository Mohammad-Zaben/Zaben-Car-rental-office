<?php
class Car
{
    private $CarID;
    private $Model;
    private $Make;
    private $Type;
    private $RegistrationYear;
    private $Description;
    private $PricePerDay;
    private $CapacityPeople;
    private $CapacitySuitcases;
    private $Colors;
    private $FuelType;
    private $AveragePetroleumConsumption;
    private $Horsepower;
    private $Length;
    private $Width;
    private $PlateNumber;
    private $Conditions;
    private $Photo1;
    private $Photo2;
    private $Photo3;
    private $PickUpLocation;
    private $GearType;


    function getTableRow()
    {
        $rwo = <<<REC
        <tr class="$this->FuelType">
        
                <td> <input type="checkbox" id="option1" name="options" value="Option 1"></td>
                <td>$this->PricePerDay</td>
                <td>$this->Type</td>
                <td>$this->FuelType</td>
                <td><figure><img src="images/$this->Photo1" alt="$this->Photo1" width=160>
                <figcaption>$this->Make . $this->Model</figcaption></figure></td> 
                <td><a href="view.php?action=view&car_id=$this->CarID">$this->CarID</a></td>
            </tr>
REC;
        return $rwo;
    }


    function getCarDetailsPage()
    {
        $photosHtml = <<<REC
        
        <section class="photo-container">
        <div class="photo">
                <figure><img src="images/$this->Photo1" alt="$this->Photo1" width=160></figure>
        </div>
        <div class="photo">
                <figure><img src="images/$this->Photo2" alt="$this->Photo2" width=160></figure>
        </div>
        <div class="photo">
                <figure><img src="images/$this->Photo3" alt="$this->Photo3" width=160></figure>
        </div>
    </section>

REC;

        $carDetailsHtml = <<<REC
            <section class="car-details">
                <ul class="styled-list">
                    <li>Car Reference Number: {$this->CarID}</li>
                    <li>Model: $this->Model</li>
                    <li>Type: $this->Type</li>
                    <li>Make: $this->Make</li>
                    <li>Registration Year: $this->RegistrationYear</li>
                    <li>Color: $this->Colors</li>
                    <li>Description: $this->Description</li>
                    <li>Price per Day: $this->PricePerDay</li>
                    <li>Capacity (People): $this->CapacityPeople</li>
                    <li>Capacity (Suitcases): $this->CapacitySuitcases</li>
                    <li>Fuel Type: $this->FuelType</li>
                    <li>Average Petroleum Consumption: $this->AveragePetroleumConsumption L/100km</li>
                    <li>Horsepower: $this->Horsepower</li>
                    <li>Length: $this->Length meters</li>
                    <li>Width: $this->Width meters</li>
                    <li>Gear Type: $this->GearType </li>
                    <li>Conditions: $this->Conditions</li>
                </ul>
            </section>               

REC;

        $markingInfoHtml = <<<REC
            <section class="marking-info">
                <p>This car is enjoyable to drive and there is a discount for long-term rentals.</p>
            </section>
REC;

        $html = <<<REC
            <main class="car-details-page">
                <artical id="view">
                    <div class="left-column">
                    $photosHtml
                    </div>
                    <div class="right-column">
                    $carDetailsHtml
                    $markingInfoHtml
                    </div>
                </artical>
                <button id="rent"><a href="rent.php?car_id=$this->CarID">Rent</a></button>
            </main>
REC;

        return $html;
    }



    public function getCarID()
    {
        return $this->CarID;
    }

    public function getModel()
    {
        return $this->Model;
    }

    public function setModel($Model)
    {
        $this->Model = $Model;
    }

    public function getMake()
    {
        return $this->Make;
    }

    public function setMake($Make)
    {
        $this->Make = $Make;
    }

    public function getType()
    {
        return $this->Type;
    }

    public function setType($Type)
    {
        $this->Type = $Type;
    }

    public function getRegistrationYear()
    {
        return $this->RegistrationYear;
    }

    public function setRegistrationYear($RegistrationYear)
    {
        $this->RegistrationYear = $RegistrationYear;
    }

    public function getDescription()
    {
        return $this->Description;
    }

    public function setDescription($Description)
    {
        $this->Description = $Description;
    }

    public function getPricePerDay()
    {
        return $this->PricePerDay;
    }

    public function setPricePerDay($PricePerDay)
    {
        $this->PricePerDay = $PricePerDay;
    }

    public function getCapacityPeople()
    {
        return $this->CapacityPeople;
    }

    public function setCapacityPeople($CapacityPeople)
    {
        $this->CapacityPeople = $CapacityPeople;
    }

    public function getCapacitySuitcases()
    {
        return $this->CapacitySuitcases;
    }

    public function setCapacitySuitcases($CapacitySuitcases)
    {
        $this->CapacitySuitcases = $CapacitySuitcases;
    }

    public function getColors()
    {
        return $this->Colors;
    }

    public function setColors($Colors)
    {
        $this->Colors = $Colors;
    }

    public function getFuelType()
    {
        return $this->FuelType;
    }

    public function setFuelType($FuelType)
    {
        $this->FuelType = $FuelType;
    }

    public function getAveragePetroleumConsumption()
    {
        return $this->AveragePetroleumConsumption;
    }

    public function setAveragePetroleumConsumption($AveragePetroleumConsumption)
    {
        $this->AveragePetroleumConsumption = $AveragePetroleumConsumption;
    }

    public function getHorsepower()
    {
        return $this->Horsepower;
    }

    public function setHorsepower($Horsepower)
    {
        $this->Horsepower = $Horsepower;
    }

    public function getLength()
    {
        return $this->Length;
    }

    public function setLength($Length)
    {
        $this->Length = $Length;
    }

    public function getWidth()
    {
        return $this->Width;
    }

    public function setWidth($Width)
    {
        $this->Width = $Width;
    }

    public function getPlateNumber()
    {
        return $this->PlateNumber;
    }

    public function setPlateNumber($PlateNumber)
    {
        $this->PlateNumber = $PlateNumber;
    }

    public function getConditions()
    {
        return $this->Conditions;
    }

    public function setConditions($Conditions)
    {
        $this->Conditions = $Conditions;
    }

    public function getPhoto1()
    {
        return $this->Photo1;
    }

    public function setPhoto1($Photo1)
    {
        $this->Photo1 = $Photo1;
    }

    public function getPhoto2()
    {
        return $this->Photo2;
    }

    public function setPhoto2($Photo2)
    {
        $this->Photo2 = $Photo2;
    }

    public function getPhoto3()
    {
        return $this->Photo3;
    }

    public function setPhoto3($Photo3)
    {
        $this->Photo3 = $Photo3;
    }

    public function getPickUpLocation()
    {
        return $this->PickUpLocation;
    }

    public function setPickUpLocation($PickUpLocation)
    {
        $this->PickUpLocation = $PickUpLocation;
    }
}
