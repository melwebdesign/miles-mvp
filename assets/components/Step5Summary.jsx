import React from "react";
import { parseISO, format } from "date-fns";


export default function Step5Summary({
                                         pickupDatetime,
                                         returnDatetime,
                                         selectedVehicle,
                                         pickupCity,
                                         returnCity,
                                         returnAtDifferentLocation,
                                         onBack,
                                         onConfirm,
                                     }) {

    return (
        <div>
            <h2 className="mb-4 text-lg font-semibold">Summary:</h2>

            <ul className="mb-6 space-y-2">
                <li>
                    <strong>Pickup date:</strong> {format(parseISO(pickupDatetime), "yyyy-MM-dd HH:mm")}
                </li>
                <li>
                    <strong>Return date:</strong> {format(parseISO(returnDatetime), "yyyy-MM-dd HH:mm")}
                </li>
                <li>
                    <strong>Vehicle:</strong> {selectedVehicle?.name}
                </li>
                <li>
                    <strong>Pickup location:</strong> {pickupCity}
                </li>

                {!returnAtDifferentLocation && (
                    <li>
                        <strong>Return location:</strong> {returnCity}
                    </li>
                )}

                {returnAtDifferentLocation && (
                    <li>
                        <strong>Return at different location:</strong> for additional fixed fee (149€)
                    </li>
                )}
            </ul>

            <div className="flex justify-between">
                <button
                    onClick={onBack}
                    className="px-6 py-2 rounded border border-gray-400 hover:bg-gray-100"
                >
                    Back
                </button>
                <button
                    onClick={onConfirm}
                    className="px-6 py-2 rounded bg-green-600 text-white hover:bg-green-700"
                >
                    Reserve
                </button>
            </div>
        </div>
    );
}
