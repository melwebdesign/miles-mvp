import React from "react";

export default function Step4CitiesAndOptions({
                                                  pickupCity,
                                                  setPickupCity,
                                                  returnCity,
                                                  setReturnCity,
                                                  returnAtDifferentLocation,
                                                  setReturnAtDifferentLocation,
                                                  onNext,
                                                  onBack,
                                                  cities,
                                              }) {
    return (
        <div>
            <label className="block mb-2 font-medium text-gray-700">Pickup location</label>
            <select
                value={pickupCity}
                onChange={(e) => setPickupCity(e.target.value)}
                className="w-full border border-gray-300 rounded p-2 mb-4"
            >
                <option value="">Choose a city</option>
                {cities.map((city) => (
                    <option key={city} value={city}>
                        {city}
                    </option>
                ))}
            </select>

            {!returnAtDifferentLocation && (
                <>
                    <label className="block mb-2 font-medium text-gray-700">Return location</label>
                    <select
                        value={returnCity}
                        onChange={(e) => setReturnCity(e.target.value)}
                        className="w-full border border-gray-300 rounded p-2 mb-4"
                    >
                        <option value="">Choose a city</option>
                        {cities.map((city) => (
                            <option key={city} value={city}>
                                {city}
                            </option>
                        ))}
                    </select>
                </>
            )}

            <div className="mb-6">
                <label className="inline-flex items-center">
                    <input
                        type="checkbox"
                        checked={returnAtDifferentLocation}
                        onChange={(e) => {
                            setReturnAtDifferentLocation(e.target.checked);
                            if (e.target.checked) {
                                setReturnCity("");
                            }
                        }}
                        className="form-checkbox"
                    />
                    <span className="ml-2">Return at different location for additional fixed fee (149€)</span>
                </label>
            </div>

            <div className="flex justify-between">
                <button
                    onClick={onBack}
                    className="px-6 py-2 rounded border border-gray-400 hover:bg-gray-100"
                >
                    Back
                </button>
                <button
                    disabled={!pickupCity || (!returnAtDifferentLocation && !returnCity)}
                    onClick={onNext}
                    className={`px-6 py-2 rounded text-white ${
                        pickupCity && (returnAtDifferentLocation || returnCity)
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
