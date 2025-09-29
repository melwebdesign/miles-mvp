import React, { useState, useEffect } from "react";
import Step1PickupDate from "./Step1PickupDate";
import Step2ReturnDate from "./Step2ReturnDate";
import Step3VehicleSelection from "./Step3VehicleSelection";
import Step4CitiesAndOptions from "./Step4CitiesAndOptions";
import Step5Summary from "./Step5Summary";

const cities = ["Berlin", "Hamburg", "Munich", "Düsseldorf"];

export default function BookingForm() {
    const [step, setStep] = useState(1);

    const [pickupDatetime, setPickupDatetime] = useState("");
    const [returnDatetime, setReturnDatetime] = useState("");
    const [vehicles, setVehicles] = useState([]);
    const [selectedVehicle, setSelectedVehicle] = useState(null);

    const [pickupCity, setPickupCity] = useState("");
    const [returnCity, setReturnCity] = useState("");
    const [returnAtDifferentLocation, setReturnAtDifferentLocation] = useState(false);

    const [modalMessage, setModalMessage] = React.useState("");
    const [modalError, setModalError] = React.useState(false);
    const [modalVisible, setModalVisible] = React.useState(false);

    useEffect(() => {
        if (pickupDatetime && returnDatetime) {
            fetchAvailableVehicles(pickupDatetime, returnDatetime);
        }
    }, [pickupDatetime, returnDatetime]);

    async function fetchAvailableVehicles(pickupDatetime, returnDatetime) {

        try {
            const res = await fetch(`/api/vehicles?startDatetime=${pickupDatetime}&endDatetime=${returnDatetime}`);
            const data = await res.json();

            setVehicles(data);
            setSelectedVehicle(null);
        } catch (error) {
            setModalMessage("An error while loading vehicles. Please, try again later.");
            setModalError(true);
            setModalVisible(true);
        }
    }

    async function handleConfirm() {
        const bookingData = {
            vehicleId: selectedVehicle?.id,
            pickupDatetime,
            returnDatetime,
            pickupCity,
            returnCity: returnAtDifferentLocation ? pickupCity : returnCity,
            returnAtDifferentLocation,
        };

        try {
            const response = await fetch("/api/reservations", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(bookingData),
            });

            if (response.ok) {
                setModalMessage("Reservation was successful!");
                setModalError(false);
                resetForm();
            } else if (response.status === 422) {
                setModalMessage("This car is already reserved. Please, try another car or dates.");
                setModalError(true);
            } else {
                setModalMessage("An error occurred. Please try again.");
                setModalError(true);
            }
        } catch {
            setModalMessage("Network problem. Please try again.");
            setModalError(true);
        } finally {
            setModalVisible(true);
        }
    }

    const resetForm = () => {
        setPickupDatetime("");
        setReturnDatetime("");
        setSelectedVehicle(null);
        setPickupCity("");
        setReturnCity("");
        setReturnAtDifferentLocation(false);
        setStep(1);
    };

    return (
        <div className="max-w-4xl mx-auto p-6 bg-white rounded shadow">
            <div className="flex justify-between mb-8">
                {[1, 2, 3, 4, 5].map((num) => (
                    <div
                        key={num}
                        className={`flex flex-col items-center ${
                            step === num ? "text-blue-600 font-bold" : "text-gray-400"
                        }`}
                    >
                        <div
                            className={`w-8 h-8 rounded-full flex items-center justify-center mb-1 ${
                                step === num ? "bg-blue-600 text-white" : "bg-gray-300 text-gray-600"
                            }`}
                        >
                            {num}
                        </div>
                        <span className="text-xs text-center">
              {{
                  1: "Pickup date",
                  2: "Return date",
                  3: "Car selection",
                  4: "Pickup/return cities",
                  5: "Confirmation",
              }[num]}
            </span>
                    </div>
                ))}
            </div>

            {step === 1 && (
                <Step1PickupDate
                    pickupDatetime={pickupDatetime}
                    setPickupDatetime={setPickupDatetime}
                    onNext={() => setStep(2)}
                />
            )}

            {step === 2 && (
                <Step2ReturnDate
                    returnDatetime={returnDatetime}
                    setReturnDatetime={setReturnDatetime}
                    onNext={() => setStep(3)}
                    onBack={() => setStep(1)}
                    pickupDatetime={pickupDatetime}
                />
            )}

            {step === 3 && (
                <Step3VehicleSelection
                    vehicles={vehicles}
                    selectedVehicle={selectedVehicle}
                    setSelectedVehicle={setSelectedVehicle}
                    onNext={() => setStep(4)}
                    onBack={() => setStep(2)}
                    pickupDatetime={pickupDatetime}
                    returnDatetime={returnDatetime}
                />
            )}

            {step === 4 && (
                <Step4CitiesAndOptions
                    pickupCity={pickupCity}
                    setPickupCity={setPickupCity}
                    returnCity={returnCity}
                    setReturnCity={setReturnCity}
                    returnAtDifferentLocation={returnAtDifferentLocation}
                    setReturnAtDifferentLocation={setReturnAtDifferentLocation}
                    onNext={() => setStep(5)}
                    onBack={() => setStep(3)}
                    cities={cities}
                />
            )}

            {step === 5 && (
                <Step5Summary
                    pickupDatetime={pickupDatetime}
                    returnDatetime={returnDatetime}
                    selectedVehicle={selectedVehicle}
                    pickupCity={pickupCity}
                    returnCity={returnCity}
                    returnAtDifferentLocation={returnAtDifferentLocation}
                    onBack={() => setStep(4)}
                    onConfirm={handleConfirm}
                />
            )}

            {modalVisible && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div className="bg-white p-6 rounded shadow max-w-sm w-full text-center">
                        <p className={`mb-4 text-lg font-semibold ${modalError ? "text-red-600" : "text-green-600"}`}>
                            {modalMessage}
                        </p>
                        <button
                            onClick={() => setModalVisible(false)}
                            className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            Close
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}
