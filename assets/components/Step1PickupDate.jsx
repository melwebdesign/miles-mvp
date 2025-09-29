import React from "react";
import DatePicker from "react-datepicker";
import { addDays, setHours, setMinutes, format } from "date-fns";

export default function Step1PickupDate({ pickupDatetime, setPickupDatetime, onNext }) {
    const minDate = addDays(new Date(), 1);

    const getMinTime = () => setHours(setMinutes(new Date(), 0), 8);
    const getMaxTime = () => setHours(setMinutes(new Date(), 0), 20);

    const handleChange = (date) => {
        if (!date) {
            setPickupDatetime(null);
            return;
        }
        const formatted = format(date, "yyyy-MM-dd'T'HH:mm");
        setPickupDatetime(formatted);
    };

    const selectedDate = pickupDatetime ? new Date(pickupDatetime) : null;

    return (
        <div>
            <label className="block mb-2 font-medium">Pickup date and time</label>
            <DatePicker
                selected={selectedDate}
                onChange={handleChange}
                showTimeSelect
                timeFormat="HH:mm"
                timeIntervals={30}
                dateFormat="yyyy-MM-dd HH:mm"
                minDate={minDate}
                minTime={getMinTime()}
                maxTime={getMaxTime()}
                placeholderText="Pick a date and time"
                className="w-full px-4 py-3 border-2 border-gray-300 rounded-md text-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            />

            <div className="mt-6 flex justify-end">
                <button
                    disabled={!pickupDatetime}
                    onClick={onNext}
                    className={`px-6 py-2 rounded text-white ${
                        pickupDatetime ? "bg-blue-600 hover:bg-blue-700" : "bg-gray-400 cursor-not-allowed"
                    }`}
                >
                    Next
                </button>
            </div>
        </div>
    );
}
