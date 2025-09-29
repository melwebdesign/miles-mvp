import React from "react";
import DatePicker from "react-datepicker";
import { addDays, setHours, setMinutes, format } from "date-fns";

export default function Step2ReturnDate({ returnDatetime, setReturnDatetime, onNext, onBack, pickupDatetime }) {
    if (!pickupDatetime) return <p>Please, pick date on a previous step.</p>;

    const minDate = addDays(new Date(pickupDatetime), 1);
    const maxDate = addDays(new Date(pickupDatetime), 60);

    const getMinTime = () => setHours(setMinutes(new Date(), 0), 8);
    const getMaxTime = () => setHours(setMinutes(new Date(), 0), 20);

    const handleChange = (date) => {
        if (!date) {
            setReturnDatetime(null);
            return;
        }
        const formatted = format(date, "yyyy-MM-dd'T'HH:mm");
        setReturnDatetime(formatted);
    };

    const selectedDate = returnDatetime ? new Date(returnDatetime) : null;

    return (
        <div>
            <label className="block mb-2 font-medium text-gray-700">Return date and time</label>
            <DatePicker
                selected={selectedDate}
                onChange={handleChange}
                showTimeSelect
                timeFormat="HH:mm"
                timeIntervals={30}
                dateFormat="yyyy-MM-dd HH:mm"
                minDate={minDate}
                maxDate={maxDate}
                minTime={getMinTime()}
                maxTime={getMaxTime()}
                placeholderText="Pick a date and time"
                className="w-full px-4 py-3 border-2 border-gray-300 rounded-md text-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <div className="mt-6 flex justify-between">
                <button
                    onClick={onBack}
                    className="px-6 py-2 rounded border border-gray-400 hover:bg-gray-100"
                >
                    Back
                </button>
                <button
                    disabled={!returnDatetime || returnDatetime <= pickupDatetime}
                    onClick={onNext}
                    className={`px-6 py-2 rounded text-white ${
                        returnDatetime && returnDatetime > pickupDatetime
                            ? "bg-blue-600 hover:bg-blue-700"
                            : "bg-gray-400 cursor-not-allowed"
                    }`}
                >
                    Next
                </button>
            </div>
        </div>
    );
}
