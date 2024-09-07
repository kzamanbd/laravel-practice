const LoadingSkeleton = () => {
    return (
        <div role="status" className="w-full animate-pulse cursor-wait">
            <div className="h-6 bg-gray-200 rounded dark:bg-gray-700 mb-2.5"></div>
            <span className="sr-only">Loading...</span>
        </div>
    );
};

export default LoadingSkeleton;
