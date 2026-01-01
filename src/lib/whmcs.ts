/**
 * WHMCS API Client
 * Handles all communication with WHMCS backend
 * Supports both API Credentials (recommended) and Legacy Admin Auth
 */

const WHMCS_API_URL = process.env.WHMCS_API_URL || 'https://app.progineous.com/includes/api.php';

// API Credentials (Recommended for WHMCS 8.x)
const WHMCS_API_IDENTIFIER = process.env.WHMCS_API_IDENTIFIER || '';
const WHMCS_API_SECRET = process.env.WHMCS_API_SECRET || '';

// Legacy Admin Authentication (fallback)
const WHMCS_ADMIN_USERNAME = process.env.WHMCS_ADMIN_USERNAME || '';
const WHMCS_ADMIN_PASSWORD = process.env.WHMCS_ADMIN_PASSWORD || ''; // Already MD5 hashed

interface WHMCSResponse {
  result: 'success' | 'error';
  message?: string;
  [key: string]: any;
}

/**
 * Get authentication parameters based on available credentials
 */
function getAuthParams(): Record<string, string> {
  // Prefer API Credentials if available
  if (WHMCS_API_IDENTIFIER && WHMCS_API_SECRET) {
    return {
      identifier: WHMCS_API_IDENTIFIER,
      secret: WHMCS_API_SECRET,
    };
  }
  // Fallback to legacy admin auth
  return {
    username: WHMCS_ADMIN_USERNAME,
    password: WHMCS_ADMIN_PASSWORD,
  };
}

/**
 * Make a request to WHMCS API
 */
async function whmcsRequest(action: string, params: Record<string, any> = {}): Promise<WHMCSResponse> {
  const authParams = getAuthParams();
  
  const formData = new URLSearchParams({
    ...authParams,
    action,
    responsetype: 'json',
    ...params,
  });

  try {
    const response = await fetch(WHMCS_API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: formData.toString(),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error('WHMCS API Error:', error);
    throw error;
  }
}

// ==================== Products & Services ====================

/**
 * Get all products
 */
export async function getProducts() {
  return whmcsRequest('GetProducts');
}

/**
 * Get product details by ID
 */
export async function getProduct(pid: number) {
  return whmcsRequest('GetProducts', { pid });
}

/**
 * Get product groups
 */
export async function getProductGroups() {
  return whmcsRequest('GetProductGroups');
}

// ==================== Domains ====================

/**
 * Check domain availability
 */
export async function checkDomainAvailability(domain: string) {
  const [sld, tld] = domain.split('.');
  return whmcsRequest('DomainWhois', {
    domain: `${sld}.${tld}`,
  });
}

/**
 * Get TLD pricing
 */
export async function getTLDPricing(currencyId: number = 1) {
  return whmcsRequest('GetTLDPricing', { currencyid: currencyId });
}

/**
 * Get domain suggestions
 */
export async function getDomainSuggestions(searchTerm: string) {
  return whmcsRequest('DomainSuggestions', { searchTerm });
}

// ==================== Client Authentication ====================

/**
 * Validate client login
 */
export async function validateLogin(email: string, password: string) {
  return whmcsRequest('ValidateLogin', { email, password2: password });
}

/**
 * Get client details
 */
export async function getClientDetails(clientId: number) {
  return whmcsRequest('GetClientsDetails', { clientid: clientId });
}

/**
 * Get client by email
 */
export async function getClientByEmail(email: string) {
  return whmcsRequest('GetClientsDetails', { email });
}

// ==================== Client Registration ====================

/**
 * Add new client
 */
export async function addClient(clientData: {
  firstname: string;
  lastname: string;
  email: string;
  password2: string;
  address1: string;
  city: string;
  state: string;
  postcode: string;
  country: string;
  phonenumber: string;
  companyname?: string;
}) {
  return whmcsRequest('AddClient', clientData);
}

// ==================== Orders ====================

/**
 * Add order
 */
export async function addOrder(orderData: {
  clientid: number;
  pid?: number;
  domain?: string;
  billingcycle?: string;
  domaintype?: 'register' | 'transfer' | 'owndomain';
  regperiod?: number;
  paymentmethod: string;
}) {
  return whmcsRequest('AddOrder', orderData);
}

/**
 * Get client orders
 */
export async function getOrders(clientId: number) {
  return whmcsRequest('GetOrders', { userid: clientId });
}

/**
 * Get order details
 */
export async function getOrder(orderId: number) {
  return whmcsRequest('GetOrders', { id: orderId });
}

// ==================== Invoices ====================

/**
 * Get client invoices
 */
export async function getInvoices(clientId: number) {
  return whmcsRequest('GetInvoices', { userid: clientId });
}

/**
 * Get invoice details
 */
export async function getInvoice(invoiceId: number) {
  return whmcsRequest('GetInvoice', { invoiceid: invoiceId });
}

// ==================== Client Services ====================

/**
 * Get client products/services
 */
export async function getClientProducts(clientId: number) {
  return whmcsRequest('GetClientsProducts', { clientid: clientId });
}

/**
 * Get client domains
 */
export async function getClientDomains(clientId: number) {
  return whmcsRequest('GetClientsDomains', { clientid: clientId });
}

// ==================== Tickets ====================

/**
 * Open support ticket
 */
export async function openTicket(ticketData: {
  clientid: number;
  deptid: number;
  subject: string;
  message: string;
  priority?: 'Low' | 'Medium' | 'High';
}) {
  return whmcsRequest('OpenTicket', ticketData);
}

/**
 * Get client tickets
 */
export async function getTickets(clientId: number) {
  return whmcsRequest('GetTickets', { clientid: clientId });
}

/**
 * Get ticket details
 */
export async function getTicket(ticketId: number) {
  return whmcsRequest('GetTicket', { ticketid: ticketId });
}

/**
 * Reply to ticket
 */
export async function addTicketReply(ticketId: number, message: string, clientId: number) {
  return whmcsRequest('AddTicketReply', {
    ticketid: ticketId,
    message,
    clientid: clientId,
  });
}

// ==================== Support Departments ====================

/**
 * Get support departments
 */
export async function getSupportDepartments() {
  return whmcsRequest('GetSupportDepartments');
}

// ==================== Announcements ====================

/**
 * Get announcements
 */
export async function getAnnouncements(limitnum: number = 10) {
  return whmcsRequest('GetAnnouncements', { limitnum });
}

// ==================== Currencies ====================

/**
 * Get currencies
 */
export async function getCurrencies() {
  return whmcsRequest('GetCurrencies');
}

// ==================== Payment Methods ====================

/**
 * Get payment methods
 */
export async function getPaymentMethods() {
  return whmcsRequest('GetPaymentMethods');
}

// ==================== Promotions ====================

/**
 * Get promotions
 */
export async function getPromotions() {
  return whmcsRequest('GetPromotions');
}

// ==================== System ====================

/**
 * Get system stats (admin only - may need different credentials)
 */
export async function getSystemStats() {
  return whmcsRequest('GetStats');
}

export default {
  // Products
  getProducts,
  getProduct,
  getProductGroups,
  
  // Domains
  checkDomainAvailability,
  getTLDPricing,
  getDomainSuggestions,
  
  // Auth
  validateLogin,
  getClientDetails,
  getClientByEmail,
  addClient,
  
  // Orders
  addOrder,
  getOrders,
  getOrder,
  
  // Invoices
  getInvoices,
  getInvoice,
  
  // Services
  getClientProducts,
  getClientDomains,
  
  // Tickets
  openTicket,
  getTickets,
  getTicket,
  addTicketReply,
  getSupportDepartments,
  
  // Other
  getAnnouncements,
  getCurrencies,
  getPaymentMethods,
  getPromotions,
};
